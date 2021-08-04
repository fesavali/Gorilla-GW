jQuery(document).ready(function(i){function s(t){i.post(ajaxurl,{action:"get_debug_log_content"},function(s){switch(s.status){case"success":t.setValue(s.content);break;case"failure":var e=`<div class="notice notice-error is-dismissible">
							<p>${s.message}</p>
							<button id="my-dismiss-admin-message" class="notice-dismiss" type="button">
								<span class="screen-reader-text">Dismiss this notice.</span>
							</button>
						</div>`;i("#title").after(e),i("#my-dismiss-admin-message").click(function(s){i(this).closest(".notice").remove()}),t.setValue("")}})}function e(){var s=i(window).height()-i("#debug_log").offset().top-360;i(".CodeMirror").height(s)}var t=i("#debug_log")[0];const n=CodeMirror.fromTextArea(t,{lineNumbers:!0,lineWiseCopyCut:!1,showCursorWhenSelecting:!0});e(),s(n),i("#reload").click(function(){s(n)}),i("#save").click(function(){var s;s=(s=n).getValue(),i.post(ajaxurl,{action:"set_debug_log_content",data:s},function(s){let e="";switch(s.status){case"success":e="notice-success";break;case"failure":e="notice-error"}s=`<div class="notice ${e} is-dismissible">
					<p>${s.message}</p>
					<button id="my-dismiss-admin-message" class="notice-dismiss" type="button">
						<span class="screen-reader-text">Dismiss this notice.</span>
					</button>
				</div>`;i("#title").after(s),i("#my-dismiss-admin-message").click(function(s){i(this).closest(".notice").remove()})})}),i(window).resize(function(){e()})});