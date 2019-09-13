<?php

// Things to notice:
// This script is called by every other script (via require_once)
// It finishes outputting the HTML for this page:
// don't forget to add your own name and student number to the footer

echo <<<_END
    <br>
    &copy;6G5Z2107 - <StudentName> - <StudentNumber> - 2019/20
    </body>
    </html>
_END;
?>