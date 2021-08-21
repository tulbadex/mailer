<!DOCTYPE html>
<html>
<head>
	<title>Mailer Script</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<div class="container">
		<div class="row justify-content-center">
			<!-- begin col-3 -->
			<div class="col-lg-8 col-md-6 col">
				<div class="registration-area">
                    <h2>Send Mail</h2>
                    <form id="mailer_form" method="post" enctype="multipart/form-data">
                      <fieldset>

                      	<div class="col-sm-12">
                          <div class="form-group"> 
                           <label class="form-control-label" for="companyName">Senders Name: </label>

                      		<input type="text" name="companyName" id="companyName" class="form-control form-control" placeholder="Enter Senders Name">
                      		<div class="invalid-feedback d-none" id="companyFeed"></div>
                          </div>
                        </div>

                      	<div class="col-sm-12">
                          <div class="form-group"> 
                           <label class="form-control-label" for="to">To: </label>

                      		<input type="text" name="to" id="to" class="form-control form-control" placeholder="Enter Sender">
                      		<div class="invalid-feedback d-none" id="toFeed"></div>
                          </div>
                        </div>

                      	<div class="col-sm-12">
                          <div class="form-group"> 
                           <label class="form-control-label" for="subject">Subject: </label>

                      		<input type="text" name="subject" id="subject" class="form-control form-control" placeholder="Enter Subject">
                      		<div class="invalid-feedback d-none" id="subjectFeed"></div>
                          </div>
                        </div>

                        <div class="col-sm-12">
                          <div class="form-group"> 
                           <label class="form-control-label" for="cc">Cc: </label>
                        	<input type="text" name="cc" id="cc" class="form-control" placeholder="Enter CC">
                        	<div class="invalid-feedback d-none" id="ccFeed"></div>
                          </div>
                        </div>

                        <div class="col-sm-12">
                          <div class="form-group"> 
                           <label class="form-control-label" for="bcc">Bcc: </label>
                        	<input type="text" name="bcc" id="bcc" class="form-control" placeholder="Enter Bcc">
                        	<div class="invalid-feedback d-none" id="bccFeed"></div>
                          </div>
                        </div>

                        <div class="col-sm-12">
                          <div class="form-group"> 
                           <label class="form-control-label" for="reply">Reply To: </label>
                        	<input type="text" name="reply" id="reply" class="form-control" placeholder="Enter Reply Email">
                        	<div class="invalid-feedback d-none" id="replyFeed"></div>
                          </div>
                        </div>

                        <div class="col-sm-12">
                          <div class="form-group"> 
                           <label class="form-control-label" for="replyName">Reply Name: </label>
                        	<input type="text" name="replyName" id="replyName" class="form-control" placeholder="Enter Reply Name">
                        	<div class="invalid-feedback d-none" id="replyNameFeed"></div>
                          </div>
                        </div>

                        <div class="col-sm-12">
                          <div class="form-group"> 
                           <label class="form-control-label" for="message">Message: </label>
                           <textarea name="message" id="message" class="form-control form-control-lg" placeholder="Enter mesage details"></textarea>
                      		<div class="invalid-feedback d-none" id="messageFeed"></div>
                          </div>
                        </div>

                        <div class="col-sm-12">
                          <div class="form-group"> 
                           <label class="form-control-label" for="upload">Upload Document: </label>
                        	<input type="file" name="upload[]" id="upload" class="form-control" multiple>
                        	<div class="invalid-feedback d-none" id="uploadFeed"></div>
                          </div>
                        </div>

                        <div class="row mt-10">
                        	
                        	<div class="col-sm-6 col-lg-6 col-md-6">
                        	  <div class="form-group"> 
                        	  	<input type="submit" name="send_message" id="send_message" class="btn btn-primary btn-send menu_upsend_messageload" value="Send Message" onclick="tinyMCE.triggerSave(true,true);">
                        	  </div>
                        	</div>

                        </div>

                        <div id="messageFeedBack"></div>

                      </fieldset>
                    </form>
                </div>
			</div>
			<!-- end col-3 -->
			

		</div>
	</div>



</body>
	<script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/tinymce/js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
		$(function () {

			$('#to, #bcc, #cc').keyup(function(event) {

			  // skip for arrow keys
			  if(event.which >= 37 && event.which <= 40) return;

			  var str = this.value.replace(/(\w)[\s,]+(\w?)/g, '$1, $2');
			  if (str!=this.value) this.value = str; 
			});

			var form = $('#mailer_form');
			form.submit(function (e) {
				e.preventDefault();
				var name 	= $('#companyName');
				var subject = $('#subject');
				var cc 		= $('#cc');
				var bcc 	= $('#bcc');
				var message = $('#subject');
				var to 	    = $('#to');

				var form_data = new FormData(this);
				//var ed 		= tinymce.get("message").getContent();
				tinyMCE.triggerSave();

				if (name.val() == "") {
					$('#companyFeed').addClass('invalid-feedback text-danger').text("Company name field can not be empty").removeClass('d-none');
					$(name).addClass('is-invalid');
				}else{
					$('#companyFeed').removeClass('invalid-feedback text-danger').addClass('d-none');
					$(name).removeClass('is-invalid');
				}

				if (to.val() == "") {
					$('#toFeed').addClass('invalid-feedback text-danger').text("To field can not be empty").removeClass('d-none');
					$(to).addClass('is-invalid');
				}else{
					$('#toFeed').removeClass('invalid-feedback text-danger').addClass('d-none');
					$(to).removeClass('is-invalid');
				}
			    

			    $('#send_message').attr('disabled', 'disabled');
			    $.ajax({
			    	url: 'php/mailer.php',
			    	method: 'post',
			    	data: form_data,
			    	//dataType: 'json',

			    	contentType: false, // The content type used when sending data to the server.
			    	cache: false,       // To unable request pages to be cached
			    	processData:false, // To send DOMDocument or non processed data file it is set to false

			    	success: function(data){
			    		//$('#messageFeedBack').html(data).addClass('text-error').delay(3000).slideUp();
			    		$('#send_message').attr('disabled', false); //fadeIn, fadeOut
			    		$('#messageFeedBack').css('display', 'block').html("<h1 class='text-success'>Email sent successfully</h1>").addClass('text-success').delay(90).slideUp();
			    		$(form)[0].reset();

			    		/*if (data.type == 'success') {
			    			$('#messageFeedBack').html(data.msg).addClass('text-success').slideDown().delay(3000).slideUp();
			    			$('#send_message').attr('disabled', false);
			    		}else if( data.type == 'error' ){
			    			$('#messageFeedBack').html(data.error).addClass('text-error').slideDown().delay(3000).slideUp();
			    		}*/

			    	}


				});


			});
		})
	</script>
	<script>
	  tinymce.init({ 
	    selector: 'textarea',
	    resize: false,
	    //schema: 'HTML5', visualblocks fullpage <iframe width="560" height="315" src="https://www.youtube.com/embed/LIMYj5mpMM4" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe> | removeformat
	    schema: 'HTML5',
	    theme: 'modern',
	    skin: 'lightgray',
	    height: '300',
	    plugins: [
	      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
	      'searchreplace wordcount visualchars code fullscreen',
	      'insertdatetime media nonbreaking save table contextmenu directionality responsivefilemanager',
	      'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help',
	      'spellchecker'
	    ],
	    toolbar1: "undo redo | bold italic underline blockquote | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | insert | styleselect | strikethrough",
	    toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor emoticons  | print preview code | codesample help | | spellchecker | formatselect",
	    image_advtab: true,
	    browser_spellcheck: true,
	    fix_list_elements: true,
	    entities: '38,amp,60,lt,62,gt',
	    relative_urls: false,
	    remove_script_host: false,
	    convert_urls: true,
	    entity_encoding: 'raw',
	    keep_styles: false,
	    menubar: false,
	    branding: false,

	  //Limit the preview styles in the menu/toolbar
	  preview_styles: 'font-family font-size font-weight font-style text-decoration text-transform',
	  wpeditimage_html5_captions: true,
	  extended_valid_elements: 'img[class=myclass|!src|border:0|alt|title|width|height|style]',

	  ///mailer
	  external_filemanager_path:"/filemanager/",
	  filemanager_title:"Responsive Filemanager" ,
	  external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
	    style_formats: [
	      { title: 'Headers', items: [
	        { title: 'h1', block: 'h1' },
	        { title: 'h2', block: 'h2' },
	        { title: 'h3', block: 'h3' },
	        { title: 'h4', block: 'h4' },
	        { title: 'h5', block: 'h5' },
	        { title: 'h6', block: 'h6' }
	      ] },

	      { title: 'Blocks', items: [
	        { title: 'p', block: 'p' },
	        { title: 'div', block: 'div' },
	        { title: 'pre', block: 'pre' }
	      ] },

	      { title: 'Containers', items: [
	        { title: 'section', block: 'section', wrapper: true, merge_siblings: false },
	        { title: 'article', block: 'article', wrapper: true, merge_siblings: false },
	        { title: 'blockquote', block: 'blockquote', wrapper: true },
	        { title: 'hgroup', block: 'hgroup', wrapper: true },
	        { title: 'aside', block: 'aside', wrapper: true },
	        { title: 'figure', block: 'figure', wrapper: true }
	      ] },
	      { title: 'Bold text', inline: 'b' },
	      { title: 'Red text', inline: 'span', styles: { color: '#ff0000' } },
	      { title: 'Red header', block: 'h1', styles: { color: '#ff0000' } },
	      { title: 'Badge', inline: 'span', styles: { display: 'inline-block', border: '1px solid #2276d2', 'border-radius': '5px', padding: '2px 5px', margin: '0 2px', color: '#2276d2' } },
	      { title: 'Table row 1', selector: 'tr', classes: 'tablerow1' }
	    ],

	    formats: {
	      alignleft: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'left' },
	      aligncenter: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'center' },
	      alignright: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'right' },
	      alignfull: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full' },
	      bold: { inline: 'span', 'classes': 'bold' },
	      italic: { inline: 'span', 'classes': 'italic' },
	      underline: { inline: 'span', 'classes': 'underline', exact: true },
	      strikethrough: { inline: 'del' },
	      customformat: { inline: 'span', styles: { color: '#00ff00', fontSize: '20px' }, attributes: { title: 'My custom format' }, classes: 'example1' },

	      alignleft: [ 
	        {selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"left"}}, 
	        {selector: "img,table", classes: "alignleft"} 
	      ], 
	      aligncenter: [ 
	        {selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"center"}}, 
	        {selector: "img,table", classes: "aligncenter"} 
	      ], 
	      alignright: [ 
	       {selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"right"}}, 
	        {selector: "img,table", classes: "alignright"} 
	      ], 
	      strikethrough: {inline: "del"}
	    },
	    visualblocks_default_state: true,
	    end_container_on_empty_block: true
	  });
	</script>
</html>