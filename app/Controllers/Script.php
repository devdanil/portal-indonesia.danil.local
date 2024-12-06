<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PelakuUsahaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Script extends BaseController
{
    public function index()
    {
        return view('admin/script/index');
    }

    public function import_file()
    {
        set_time_limit(1800);

        $file = $this->request->getFile('fileExcel');

        $reader = IOFactory::createReaderForFile($file->getPathname());
        $reader->setReadDataOnly(true); // Set to read-only mode
        $spreadsheet = $reader->load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();    

        // Get the first sheet
        $chunkSize = 1000;
        $totalRows = $worksheet->getHighestRow();
        // $db = \Config\Database::connect(); // Access the database service

        // Process the spreadsheet in chunks
        for ($startRow = 2; $startRow <= $totalRows; $startRow += $chunkSize) {
            $endRow = $startRow + $chunkSize - 1;
            if ($endRow > $totalRows) {
                $endRow = $totalRows;
            }

            // Read and process rows from $startRow to $endRow
            for ($row = $startRow; $row <= $endRow; $row++) {
                $cellValueA = $worksheet->getCell('A' . $row)->getValue();
                $cellValueAK = $worksheet->getCell('AK' . $row)->getValue();

                $status = null;

                switch (strtolower($cellValueAK)) {
                    case 'aktif':
                        $status = 1;
                        break;
                    case 'tidak dapat dihubungi':
                        $status = 2;
                        break;
                    case 'belum merespon':
                        $status = 2;
                        break;
                    case 'tidak aktif':
                        $status = 2;
                        break;                    
                    default:
                        $status = 2;
                        break;                    
                }

                echo "Pelaku usaha id $cellValueA status : $status";
                echo "<br>";

                // Define your custom SQL update statement with db::raw
                // $sql = "UPDATE pelaku_usaha SET status_pelaku_usaha = " . $db->escape($status) . " WHERE id_pelaku = " . $db->escape($cellValueA);
                // Execute the raw SQL query
                // $db->query($sql);
                // $pelaku->update($cellValueA,['status_pelaku_usaha'=>$status]);
            }

            // You can perform additional operations with the chunked data here
            echo "<br>";
            echo "Processed rows from $startRow to $endRow\n";
            echo "<br>";
        }

        echo "success update status";
    }
}
