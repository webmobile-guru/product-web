<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function index()
    {
        $path=resource_path('lang/en');
        $files = $this->listFolderFiles($path);
        $r_trim_file= rtrim($files,"<br>");
        $file_list_path= explode("<br>",$r_trim_file);
        $data['file_list_path']=$file_list_path;

        return view('admin.language.language',$data);

    }

    public function getLanguageKeys(Request $request) {


        $this->validate($request, [
            'names_paths' => 'required',
        ]);

        $path=resource_path('lang');
        $files = $this->listFolderFiles($path.'/en');
        $r_trim_file= rtrim($files,"<br>");
        $file_list_path= explode("<br>",$r_trim_file);
        $data['file_list_path']=$file_list_path;
        $data['request']=$request;

        try {

            $file_path=$path.'/'.$request->lang_name.'/'.$request->names_paths;
            $request->session()->put('file_path', $file_path);

            if(is_readable($file_path)){
                $myfile = fopen($file_path, "r") or die("Unable to open file!");
                $contentLang = fread($myfile,filesize($file_path));
            }
            $replace = str_replace("<?php","","$contentLang");
            $contentLanguage = str_replace("?>","","$replace");

            if($request->lang_name=='en'){ $data['language']='English'; }
            if($request->lang_name=='fr'){ $data['language']='French'; }

            $data['contentLang']=eval($contentLanguage);


        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            flash()->error('Error! There is an error saving language');
        }

        return view('admin.language.language',$data);
    }

    public function setLanguageKey()
    {
        if(isset($_POST['Change'])){
            $key_result_lang=($_POST['key_name']);
            $val_result_lang=($_POST['key_val']);

            $com_lang= (array_combine($key_result_lang,$val_result_lang));

            $str_lang = '';


            foreach ($com_lang as $key=>$c_val){
                if($key!=''){
                    $result_lang= "'".$key."'=>'".$c_val."',";
                    $str_lang .= $result_lang."\n";
                }
            }

            $lang_data = "<?"."php\n "."return[\n".$str_lang."];?>";

            $file_path = Session::get('file_path');
            $myfile = fopen($file_path, "w+") or die("Unable to open file!");
            fwrite($myfile, $lang_data);

            flash()->success('Successfully updated');
            return redirect('admin/language');

        }
    }

    function listFolderFiles($dir){
        $str = '';
        $i = 0;
        $list = array();
        $ffs = scandir($dir);
        foreach($ffs as $ff){
            if ( $ff != '.' && $ff != '..' ){
                if ( strlen($ff)>=5 ) {
                    if ( substr($ff, -4) == '.php' ) {
                        $list[] = $ff;
                        $str .= $dir."/".$ff."<br>";
                    }
                }
                if( is_dir($dir.'/'.$ff) ){
                    $a = $this->listFolderFiles($dir.'/'.$ff);
                    $str .= $a."<br>";
                }
            }
        }
        return $str;

    }
}
