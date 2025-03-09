<?php
use Core\Flash;
if(Flash::exists(Flash::ERROR)){
    Flash::display(Flash::ERROR);
}
?>
