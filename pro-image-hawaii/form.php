<?php session_start(); ?>
<?php $_SESSION['mb_file_names'] = ""; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/swfupload.js" type="text/javascript"></script>
<script src="js/swfupload.queue.js" type="text/javascript"></script>
<script src="js/fileprogress.js" type="text/javascript"></script>
<script src="js/handlers.js" type="text/javascript"></script>

<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(".serrors").hide();
		});


		var swfu;

		window.onload = function() {
			var settings = {
				file_post_name : "Filedata",
				flash_url : "swf/swfupload.swf",
				flash9_url : "swf/swfupload_fp9.swf",
				upload_url: "upload.php",
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
				file_size_limit : "1024 MB",
				file_types : "*.txt;*.doc;*.docx;*.odt;*.rtf;*.ppt;*.pdf;*.jpg;*.jpeg;*.gif;*.png;*.tiff;*.tif;*.svg;*.zip;*.dgl;*.idd;*.qxp;*.qxd;*.psd;*.7z;*.rar;*.sit;*.sitx;*.bmp;*.pptx;*.xls;*.xlsx;*.eps;*.pub;*.ai",
				file_types_description : "",
				file_upload_limit : 100,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel",
					upload_successful : false
				},
				debug: false,

				// Button settings
				button_image_url: "images/XPButtonUploadText_61x22.png",
				button_width: "61",
				button_height: "22",
				button_placeholder_id: "spanButtonPlaceHolder",
				//button_text: '<span class="theFont">Browse</span>',
				//button_text_style: ".theFont { font-size: 16; }",
				//button_text_left_padding: 12,
				//button_text_top_padding: 3,
				
				// The event handler functions are defined in handlers.js
				swfupload_loaded_handler : swfUploadLoaded,
				swfupload_preload_handler : preLoad,
				swfupload_load_failed_handler : loadFailed,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };
</script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding: 0 5px 0 10px;">
    <form id="form1" name="uploaderForm" class="bod_txt2_g upload" enctype="multipart/form-data" action="success.php" method="get">
        Your Name<sup>&#42;</sup>: <br />
        <input id="from_name" name="from_name" class="required" size="50" /> <span id="span_from_name" class="serrors">This field is required.</span>
        <br />
        <br />
        Your Email<sup>&#42;</sup>: <br />
        <input id="from_email" name="from_email" class="required email" size="50" /> <span id="span_from_email" class="serrors">This field is required.</span>
        <br />
        <br />
        Re-enter Email<sup>&#42;</sup>: <br />
        <input id="email_confirm" name="email_confirm" class="required" size="50" /> <span id="span_email_confirm" class="serrors">This field is required.</span>
        <br />
        <br />
        Company: <br />
        <input name="from_company" size="50" />
        <br />
        <br />
        Phone<sup>&#42;</sup> <em>(Should be a 10-digit number with area code, e.g. (808) 222-2117)</em>: <br />
        <input id="from_phone1" name="from_phone1" class="required phone" size="10" onchange="phoneValidator(this.value)" /> <span id="span_from_phone1" class="serrors">This field is required.</span>
        <br />
        <br />
        <a href="http://www.proimagehawaii.com/upload/location.html" id="upload" target="_blank">Location</a><sup>&#42;</sup>:
        <select id="to_email" name="to_email" class="required">
          <option value="">Please Select a Location</option>
          <option value="sajimine">Shawna Ajimine, Store/Sales Manager</option>
          <option value="merchant">Merchant</option>
          <option value="bishop">Bishop</option>
          <option value="alakea">Alakea</option>
          <option value="queen">Queen</option>
          <option value="kapiolani">Kapiolani</option>
          <option value="university">University</option>
          <option value="ahua">Mapunapuna</option>
        </select>
        
        <span id="span_to_email" class="serrors">This field is required.</span>
        <br />
        <br />
         Please select at least one file. You may select multiple files as well<sup>&#42;</sup>: <span id="span_fileup" class="serrors">This field is required.</span>
        <br />
        
        <div class="fieldset flash" id="fsUploadProgress">
        <span class="legend">Upload Queue</span>
        </div>
        <div id="divStatus">0 Files Uploaded</div>
        <div>
            <span id="spanButtonPlaceHolder"></span>
            <input id="btnCancel" type="button" value="Cancel All Uploads" onClick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px;" />
        </div>
        
        <br />
        <small>Allowed file types: 7Z, AI, DGL, DOC, DOCX, EPS, GIF, IDD, IT, ITX, JPEG, JPG, MP, ODT, PDF, PNG, PPT, PPTX, PSD, PUB, QXD, QXP, RTF, SVG, TIFF, TIF, TXT, XLS, XLSX, ZIP</small>
        <br />
		<br />
		<span style="font-weight:bold; font-size:1.1em; color:#006633">Once your files are ready to be uploaded in the Upload Queue, please put your Special Instructions below and press the  Submit button located at the bottom of this page.</span>
		<br />
		<br />
        Special Instructions:<br />
        <textarea name="instruction" rows="10" cols="60"></textarea>
        <br />
        <br />
        <input type="submit" name="SubmitFile" id="btnSubmit" value="Submit" accesskey="ENTER" tabindex="2" class="btn_red" />
        <br />
        <br />
        <small id="showInfoBtn" style="display:none; color:#FF0000;">* Uploading bigger files might take some time. <br />* Please do not close this window until the uploading finishes and a confirmation message is shown.</small>
        <br />
      </form></td>
    <td width="1"><img src="images/spacer.png" width="9" height="24" alt="spacer" /></td>
  </tr>
</table>
</body>
</html>