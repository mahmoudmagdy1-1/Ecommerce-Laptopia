<?php
use Core\Flash;
if(Flash::exists(Flash::SUCCESS)){
    Flash::display(Flash::SUCCESS);
}
?>
