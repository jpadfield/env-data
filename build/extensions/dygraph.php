<?php

$extensionList["dygraph"] = "extensionDygraph";

function titleRow ($str)
  {$str = '<div class="row"><div class="col-md-12"><h5>'.
    $str.'</h5></div></div>';
   return($str);}

function formInput($name, $title, $type, $value=false, $cols=6, $nlw = 75, $jsfn="",
  $trTxt=false, $trw=70, $readonly=false, $placeholder=false)
  {
  $nameLeft = '<div class="input-group-prepend">'.
    '<span class="input-group-text" style="width:'.
      $nlw.'px;" id="basic-addon-'.$name.'">'.$title.'</span></div>';
  $exl = "";
  $exr = "";
  $describeBy = ' aria-label="'.$title.
    '" aria-describedby="basic-addon-'.$name.'"';

  if ($readonly)
    {$readonly = "readonly";}
    
  if ($trTxt)
    {$tagRight = '<div class="input-group-append"><span style="'.
      'min-width:'.$trw.'px;"  class="input-group-text" id="basic-addon-'.
      $name.'">'.$trTxt.'</span></div>';}
  else
    {$tagRight = "";}

  if ($type == "date")
    {
    $exl = '<div class="datepicker date input-group p-0 shadow-sm">';
    $exr = '</div>';
    $tagRight = '<div class="input-group-append"><span class="'.
      'input-group-text px-4"><i class="fa fa-calendar-o"></i>'.
      '</span></div>';
    $input = '<input onchange="'.$jsfn.'(this.id)" type="text" placeholder="'.
      $title.' date" class="form-control py-4 px-4" id="'.$name.'" '.
      $describeBy.' '.$readonly.'>';
    }
  else if ($type == "select")
    {
    $input = '<select onchange="'.$jsfn.'(this.id)" class="form-control" id="'.
      $name.'" '.$describeBy.' '.$readonly.'></select>';
    }
  else //if ($type == "text")
    {
    $input = '<input onChange="'.$jsfn.'(this.id)" placeholder="'.$placeholder.'" '.
      'type="text" class="form-control" id="'.$name.'" '.$describeBy.
      ' '.$readonly.'>';
    }
    
    
  ob_start();
	echo <<<END
  <div class="input-group col-md-${cols}">						
    $exl
      $nameLeft
			$input
			$tagRight
    $exr
  </div>
END;
  $html = ob_get_contents();
  ob_end_clean(); // Don't send output to client
  return ($html);
  }

function alertRow ($id, $type, $comment, $tp=0)
  {
  ob_start();
  echo <<<END
  <div class="row" style="padding-left:15px;padding-right:15px;margin-top:${tp}rem;">
    <div class="alert alert-${type} col-md-12" role="alert" id="$id">
      $comment</div></div>
END;
  $html = ob_get_contents();
  ob_end_clean(); // Don't send output to client
  return ($html);
  }
      
function extensionDygraph ($d, $pd)
  {
  if (isset($d["file"]) and file_exists($d["file"]))
		{$dets = getRemoteJsonDetails($d["file"], false, true);}
  else
    {$dets = array();}
  
  $pd["extra_js_scripts"][] =
			"https://cdnjs.cloudflare.com/ajax/libs/dygraph/2.1.0/dygraph.min.js";
  $pd["extra_js_scripts"][] =
			"https://cdnjs.cloudflare.com/ajax/libs/dygraph/2.1.0/dygraph.min.js.map";
  $pd["extra_js_scripts"][] =
			"https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js";
  
  $pd["extra_css_scripts"][] =
    "https://cdnjs.cloudflare.com/ajax/libs/dygraph/2.1.0/dygraph.min.css";
  $pd["extra_css_scripts"][] =
    "https://cdnjs.cloudflare.com/ajax/libs/dygraph/2.1.0/dygraph.min.css.map";
  $pd["extra_css_scripts"][] =
    "https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css";
      
  $pd["extra_js"] .= "
    ";

  $pd["extra_onload"] .= "

  $(function () { // INITIALIZE DATEPICKER PLUGIN
    $('.datepicker').datepicker({
      clearBtn: true,
      format: \"yyyy-mm-dd\"});});

  $(function () {
    $('[data-toggle=\"tooltip\"]').tooltip()})

  buildDropdowns ()

  ";
   
  $titles = array(
    );

  $inputs = array(
    );
    
		//do we need tooltips?			
		//<div class="input-group col-md-6" data-toggle="tooltip" data-placement="top" title="Standard operating lux Level.">

  $alerts = array(
    );
    
	if (isset($d["file"]) and file_exists($d["file"]))
		{
		ob_start();
		echo <<<END

END;
    $mcontent = ob_get_contents();
		ob_end_clean(); // Don't send output to client

		$d["content"] = positionExtraContent ($d["content"], $mcontent);

		}	

  return (array("d" => $d, "pd" => $pd));
  }
    
?>
