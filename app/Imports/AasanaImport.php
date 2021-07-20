<?php
   
namespace App\Imports;
   
use App\Models\AasanaCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
    
class AasanaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        echo "<pre>";
        print_r($row);die;
        return new AasanaCategory([
            'name'     => $row['name'],
            'email'    => $row['email'], 
            'password' => \Hash::make($row['password']),
        ]);
    }
}