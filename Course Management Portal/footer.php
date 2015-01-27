<?php

if( isset( $_SESSION[ 'user_id' ] ) )
	$user = USER::find_by_user_ID( $_SESSION[ 'user_id' ] );

?>

				</div><!-- END .PopupPage-FormHolder-->
			</div><!-- END .PopupPage-BodyContainer -->
			<div class="PopupPage-Footer">
				<h4>Currently logged on as: <?php ( isset( $_SESSION[ 'user_id' ] ) ) ? print( $user->full_name() ) : print( '' ); ?></h4>
			</div>
		</div><!-- END .PopupPage-MainContainer-->
	</body>

</html>