<?php
namespace App\Http\Controllers;
//namespace App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\AasanaCategory;
use App\Models\AasanaSubCategory;
use App\Models\Aasana;


use Auth;
use Illuminate\Routing\Controller as BaseController;

class SpreadsheetController extends BaseController
{
    public function importExcelView()
    {
        return view("excel.import");
    }
  
    function Import(Request $request)
    {
        $login_user_id  = Auth::user()->id;
        if($_FILES["aasana_excel"]["name"] != '')
        {
            $allowed_extension = array('xls', 'csv', 'xlsx');
            $file_array = explode(".", $_FILES["aasana_excel"]["name"]);
            $file_extension = end($file_array);                
            if(in_array($file_extension, $allowed_extension))
            {
                $file_name = time() . '.' . $file_extension;
                move_uploaded_file($_FILES['aasana_excel']['tmp_name'], $file_name);
                $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
                
                $spreadsheet = $reader->load($file_name);
                $excelSheet = $spreadsheet->getActiveSheet();
                $spreadSheetAry = $excelSheet->toArray();
                $sheetCount = count($spreadSheetAry);
    
                for ($i = 0; $i <= $sheetCount; $i ++) 
                {
                    $category_name = "";
                    if (isset($spreadSheetAry[$i][0]))
                    {
                        $category_name = $spreadSheetAry[$i][0];
                    }
                    $category_description = "";
                    if (isset($spreadSheetAry[$i][1]))
                    {
                        $category_description = $spreadSheetAry[$i][1];
                    }
                    $subcategory_name = "";
                    if (isset($spreadSheetAry[$i][2]))
                    {
                        $subcategory_name = $spreadSheetAry[$i][2];
                    }
                    $category_description = "";
                    if (isset($spreadSheetAry[$i][3]))
                    {
                        $category_description = $spreadSheetAry[$i][3];
                    }
                    $aasana_name = "";
                    if (isset($spreadSheetAry[$i][4]))
                    {
                        $aasana_name = $spreadSheetAry[$i][4];
                    }
                    $aasana_description = "";
                    if (isset($spreadSheetAry[$i][5]))
                    {
                        $aasana_description = $spreadSheetAry[$i][5];
                    }
                    $assana_video_duration = "";
                    if (isset($spreadSheetAry[$i][3]))
                    {
                        $assana_video_duration = $spreadSheetAry[$i][3];
                    }
                    $assana_video_id = "";
                    if (isset($spreadSheetAry[$i][6]))
                    {
                        $assana_video_id = $spreadSheetAry[$i][6];
                    }
                    $assana_tag = "";
                    if (isset($spreadSheetAry[$i][7]))
                    {
                        $assana_tag = $spreadSheetAry[$i][7];
                    }             
                    $updated_by = "";
                    if (isset($spreadSheetAry[$i][8]))
                    {
                        $updated_by = $spreadSheetAry[$i][8];
                    } 
                    if (! empty($category_name) || ! empty($category_description) || ! empty($subcategory_name) || ! empty($category_description) || ! empty($aasana_name) || ! empty($aasana_description) || ! empty($assana_video_duration) || ! empty($assana_video_id)  || ! empty($updated_by))
                    {
                        $aasana_category_list= AasanaCategory::where('category_name',$category_name)->first();
                        if($aasana_category_list)
                        {
                            $category_id=$aasana_category_list->id;
                        }
                        else
                        {
                            $insert_category_data = array
                            (                              
                                'category_name'  => $category_name,
                                'category_description'  => $category_description,
                                'status'  =>1,
                                'updated_by'  => $login_user_id,            
                            
                            );
                             $category_insert_Id = AasanaCategory::create($insert_category_data);
                             $category_id=$category_insert_Id->id;
                        }
                        if($category_id)
                        {
                            $aasana_sub_category_list= AasanaSubCategory::where('subcategory_name',$subcategory_name)->where('aasana_categories_id',$category_id)->first();

                            if($aasana_sub_category_list)
                            {
                                $sub_category_id=$aasana_sub_category_list->id;
                                $aasana_categories_id=$aasana_sub_category_list->aasana_categories_id;
                            }
                            else
                            {
                                $insert_sub_category_data = array
                                (                              
                                    'subcategory_name'  => $subcategory_name,
                                    'category_description'  => $category_description,
                                    'status'  =>1,                              
                                    'updated_by'  => $login_user_id,            
                                
                                );
                                 $sub_category_insert_Id = AasanaSubCategory::create($insert_sub_category_data);
                                 $sub_category_id=$sub_category_insert_Id->id;
                            }
                        }
                        if($sub_category_id)
                        {
                            $aasana_list= Aasana::where('aasana_name',$aasana_name)->where('aasana_sub_categories_id',$sub_category_id)->first();
                        
                        if($aasana_list){

                        }
                        else
                        {
                            $insert_aasana_data = array(                              
                                'category_name'  => $category_name,
                                'aasana_description'  => $aasana_description,
                                'assana_video_duration'  =>$assana_video_duration,
                                'assana_video_id'  => $assana_video_id,
                                'assana_tag'  => $assana_tag,
                                'status'=>1,
                                'updated_by'  => $updated_by,                         
                            
                        );
                        $aasana_insert_Id = Aasana::create($insert_aasana_data);
                        return redirect('excel/importexcelview')->with('success', 'Data imported successfully!');    
                        }

                        }
                    }

                }               
            }
        }
    }

}