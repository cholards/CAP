<?php declare(strict_types=1);

require __DIR__.'/../bootstrap/bootstrap.php';

// Check command line parameters
if (count($argv) !== 2) {
    echo "Missing parameter - GitHub user ID - "
        . "e.g. php bin/get_starred_repos.php 'sebastianbergmann' \r\n";
    return;
}
$userInput = $argv[1];

// TODO Create an instance of the GithubService, passing it an instance of \Github\Client via dependency injection

// GitHub user
$user = $userInput;

// curl URL
$curl_url = "https://api.github.com/users/". $user ."/starred";

// curl
$ch = curl_init($curl_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Set headers
curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: CAP-Project'));

// Execute the curl
$output = curl_exec($ch);

// Close curl       
curl_close($ch);

// Decode output
$output = json_decode($output);
$total = 0;

//Condition for display or result
if (!empty($output)) {
 echo "\t\n \r\n Below is a list of all starred repos of $user  as at " .  date('Y-m-d') . "\r\n"  ;
// List of starred repos
  foreach ($output as $repo) {
   $total = $total+1;
 print "\n" ."(" . $total . ") REPOSITORY NAME: " . $repo->name  . '     =>   DATE: ' . $repo->created_at . "\n";
 }
 echo  "\n". "Total starred repositories is $total" . "\n" . "\n";
} else {

  // TODO get the results back from the countStarredReposForUser method and output the results onto the screen

// Display if result is empty

echo " \r\n \r\n The user '" . $user ."' does not exist on GitHub or has no starred repositories at this time \r\n \r\n";
}
