<?php

// Run the Git command to get the current branch name
exec('git rev-parse --abbrev-ref HEAD', $output, $return_var);
if ($return_var === 0):
    $git_branch = $output[0];
else:
    // Handle error
    $git_branch = "unknown";
endif;

// Run the Git command to get the current commit ID
exec('git rev-parse HEAD', $output2, $return_var2);
if ($return_var2 === 0):
    $git_commit_id = substr($output2[0], 0, 7);
else:
    // Handle error
    $git_commit_id = "unknown";
endif;
