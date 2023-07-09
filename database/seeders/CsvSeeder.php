<?php

namespace Database\Seeders;

use App\Models\Participante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

class CsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function generatePassword()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789#&/!?';
        $password = '';

        for ($i = 0; $i < 8; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $password .= $characters[$index];
        }

        return $password;
    }
    public function run()
    {
        $excelFile = public_path('seeds/data.xlsx'); // Ruta al archivo Excel

        $spreadsheet = IOFactory::load($excelFile);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        array_shift($rows);
        $passwords=[];
        foreach ($rows as $row){
            $password=$this->generatePassword();
            array_push($passwords,$password);
            Participante::create([
                "nombres"=>$row[1],
                "cedula"=>$row[2],
                "email"=>$row[3],
                "password"=>bcrypt($password),
                "semestre"=>$row[4],
                "telefono"=>$row[6],
            ]);
        }
        $participantes=Participante::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Nombres');
        $sheet->setCellValue('C1', 'Cedula');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Password');
        $sheet->setCellValue('F1', 'Semestre');
        $sheet->setCellValue('G1', 'Telefono');

        $row = 2;
        $i=0;
        foreach ($participantes as $item) {
            $sheet->setCellValue('A' . $row, $item->id);
            $sheet->setCellValue('B' . $row, $item->nombres);
            $sheet->setCellValue('C' . $row, $item->cedula);
            $sheet->setCellValue('D' . $row, $item->email);
            $sheet->setCellValue('E' . $row, $passwords[$i]);
            $sheet->setCellValue('F' . $row, $item->semestre);
            $sheet->setCellValue('G' . $row, $item->telefono);
            $row++;
            $i++;
        }
        $writer = new WriterXlsx($spreadsheet);

        // Define el nombre del archivo Excel a exportar
        $filename = 'datosPassword.xlsx';

        // Guarda el archivo Excel en la carpeta storage/app/public
        $writer->save(storage_path('app/public/seeds/' . $filename));
    }
}
