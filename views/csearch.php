<html>
<head>
	<title>Search!</title>
</head>

<body>

	<script>
  		(function() {
		      var cx = '002983451055951785828:gvpl63cui1i';
			      var gcse = document.createElement('script');
			      gcse.type = 'text/javascript';
				      gcse.async = true;
				      gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
							          '//www.google.com/cse/cse.js?cx=' + cx;
					      var s = document.getElementsByTagName('script')[0];
					      s.parentNode.insertBefore(gcse, s);
		}


		function post_to_url(path, params, method) {
		    method = method || "post"; // Set method to post by default if not specified.
	
    // The rest of this code assumes you are not using a library.
	//     // It can be made less wordy if you use one.
	         var form = document.createElement("form");
	             form.setAttribute("method", method);
	             form.setAttribute("action", path);
	//
	                     for(var key in params) {
	                            if(params.hasOwnProperty(key)) {
	                                         var hiddenField = document.createElement("input");
	                                                    hiddenField.setAttribute("type", "hidden");
	                                                                 hiddenField.setAttribute("name", key);
	                                                                             hiddenField.setAttribute("value", params[key]);
	
	                                                                                         form.appendChild(hiddenField);
	                                                                                                  }
	                                                                                                      }
	
	                                                                                                          document.body.appendChild(form);
	                                                                                                              form.submit();
		}
		post_to_url()

)
				
				();
  	</script>
	<gcse:search></gcse:search>
</body>

</html>
