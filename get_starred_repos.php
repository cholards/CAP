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

// for example your user
$user = $userInput;

// A token that you could generate from your own github 
// go here https://github.com/settings/applications and create a token
// then replace the next string
$token = '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';

// We generate the url for curl
$curl_url = 'https://api.github.com/users/' . $user . '/starred';

// We generate the header part for the token
$curl_token_auth = 'Authorization: token ' . $token;

// We make the actuall curl initialization
$ch = curl_init($curl_url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// We set the right headers: any user agent type, and then the custom token header part that we generated
curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Awesome-Octocat-App', $curl_token_auth));

// We execute the curl
$output = curl_exec($ch);
//echo $output;
// And we make sure we close the curl       
curl_close($ch);

// Then we decode the output and we could do whatever we want with it
$output = json_decode($output);
$total = 0;
if (!empty($output)) {
  // now you could just foreach the repos and show them
  echo "\t\n \r\n Below is a list of all starred repos of $user  as at " .  date('Y-m-d') . "\r\n"  ;

  foreach ($output as $repo) {
   $total = $total+1;
   print "\n" ."(" . $total . ") " . $repo->name  . ' => ' . $repo->created_at . "\n";
  }
  echo  "\n". "Total starred repositories is $total" . "\n" . "\n";
} else {

  // TODO get the results back from the countStarredReposForUser method and output the results onto the screen
 echo "NO STARRED REPOS AT THIS TIME \r\n";

}




