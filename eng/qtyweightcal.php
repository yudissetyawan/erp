<?php

function QWcalculate($s,$t,$w,$l,$W,$id){
	$value=0;
	if($s==0){
		if($t==0){
			if($w==0){
				if($l==0){
					if($W!=0) $value=$W;
				}else {
					if($W!=0) $value=$l*$W;
				}
			} else {
				if($l==0){
					if($W!=0) $value=$w * $W;
				}else {
					if($W!=0) $value=$w * $l * $W;
				}
			}
		} else {
			if($w==0){
				if($l==0){
					if($W!=0) $value=$t * $W;
				}else {
					if($W!=0) $value=$t * $l * $W;
				}
			} else {
				if($l==0){
					if($W!=0) $value=$t * $w * $W;
				}else {
					if($W!=0) $value=$t * $w * $l * $W;
				}
			}
		} 
	} else {
		if($t==0){
			if($w==0){
				if($l==0){
					if($W!=0) $value=$s * $W;
				}else {
					if($W!=0) $value=$s * $l * $W;
				}
			} else {
				if($l==0){
					if($W!=0) $value=$s * $w * $W;
				}else {
					if($W!=0) $value=$s * $w * $l * $W;
				}
			}
		} else {
			if($w==0){
				if($l==0){
					if($W!=0) $value=$s * $t * $W;
				}else {
					if($W!=0) $value=$s * $t * $l * $W;
				}
			} else {
				if($l==0){
					if($W!=0) $value=$s * $t * $w * $W;
				}else {
					if($W!=0) $value=$s * $t * $w * $l * $W;
				}
			}
		}
	}
	?>
    	<script>
			var hasil<?php echo $id; ?>=(<?php echo $value ;?>).toFixed(3) ;
        </script>
    <?php
}

?>

