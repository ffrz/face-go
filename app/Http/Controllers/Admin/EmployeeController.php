<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmployeeController extends Controller
{
    public function index()
    {
        return inertia('admin/employee/Index');
    }

    public function detail($id = 0)
    {
        return inertia('admin/employee/Detail', [
            'data' => Employee::query()->findOrFail($id),
        ]);
    }

    public function data(Request $request)
    {
        $orderBy = $request->get('order_by', 'nik');
        $orderType = $request->get('order_type', 'asc');
        $filter = $request->get('filter', []);

        $q = Employee::query();

        if (!empty($filter['search'])) {
            $q->where(function ($q) use ($filter) {
                $q->where('nik', 'like', '%' . $filter['search'] . '%');
                $q->orWhere('name', 'like', '%' . $filter['search'] . '%');
                $q->orWhere('phone', 'like', '%' . $filter['search'] . '%');
                $q->orWhere('address', 'like', '%' . $filter['search'] . '%');
            });
        }

        if (!empty($filter['status']) && (in_array($filter['status'], ['active', 'inactive']))) {
            $q->where('active', '=', $filter['status'] == 'active' ? true : false);
        }

        $q->orderBy($orderBy, $orderType);

        $items = $q->paginate($request->get('per_page', 10))->withQueryString();

        return response()->json($items);
    }

    public function duplicate($id)
    {
        $item = Employee::findOrFail($id);
        $item->id = null;
        $item->created_at = null;
        return inertia('admin/employee/Editor', [
            'data' => $item,
        ]);
    }

    public function editor($id = 0)
    {
        allowed_roles([User::Role_Admin]);
        
        $item = $id ? Employee::findOrFail($id) : new Employee(['active' => true]);
        return inertia('admin/employee/Editor', [
            'data' => $item,
            'users' => User::where('active', true)->orderBy('username', 'asc')->get(),
        ]);
    }

    public function save(Request $request)
    {
        allowed_roles([User::Role_Admin]);

         $validated = $request->validate([
            'nik' => 'required|string|max:40|unique:employees,nik' . ($request->id ? ',' . $request->id : ''),
            'name' => 'required|max:255',
            'phone' => 'required|max:100',
            'address' => 'required|max:1000',
            'active'   => 'required|boolean',
            'notes' => 'nullable|max:1000',
            'password' => (!$request->id ? 'required|' : '') . 'min:5|max:40',
        ]);

        $item = !$request->id ? new Employee() : Employee::findOrFail($request->id);
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }
        $item->fill($validated);
        $item->save();

        return redirect(route('admin.employee.detail', ['id' => $item->id]))->with('success', "Karyawan $item->name telah disimpan.");
    }

    public function delete($id)
    {
        allowed_roles([User::Role_Admin]);

        $item = Employee::findOrFail($id);
        $item->delete();

        return response()->json([
            'message' => "Karyawan $item->name telah dihapus."
        ]);
    }

    /**
     * Mengekspor daftar client ke dalam format PDF atau Excel.
     */
    public function export(Request $request)
    {
        $items = Employee::orderBy('id', 'asc')->get();

        $title = 'Daftar Karyawan';
        $filename = $title . ' - ' . env('APP_NAME') . Carbon::now()->format('dmY_His');

        if ($request->get('format') == 'pdf') {
            $pdf = Pdf::loadView('export.employee-list-pdf', compact('items', 'title'))
                ->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        }

        if ($request->get('format') == 'excel') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Tambahkan header
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'NIK');
            $sheet->setCellValue('C1', 'Nama');
            $sheet->setCellValue('D1', 'Telepon');
            $sheet->setCellValue('E1', 'Alamat');
            $sheet->setCellValue('F1', 'Status');
            $sheet->setCellValue('G1', 'Catatan');

            // Tambahkan data ke Excel
            $row = 2;
            foreach ($items as $item) {
                $sheet->setCellValue('A' . $row, $item->id);
                $sheet->setCellValue('B' . $row, $item->nik);
                $sheet->setCellValue('C' . $row, $item->name);
                $sheet->setCellValue('D' . $row, $item->phone);
                $sheet->setCellValue('E' . $row, $item->address);
                $sheet->setCellValue('F' . $row, $item->active ? 'Aktif' : 'Tidak Aktif');
                $sheet->setCellValue('G' . $row, $item->notes);
                $row++;
            }

            // Kirim ke memori tanpa menyimpan file
            $response = new StreamedResponse(function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            });

            // Atur header response untuk download
            $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '.xlsx"');

            return $response;
        }

        return abort(400, 'Format tidak didukung');
    }
}
