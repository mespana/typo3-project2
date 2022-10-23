<?php
namespace Deployer;

require 'recipe/typo3.php';

// Project name
set('application', 'typo3-project2');

// Project repository
set('repository', 'git@github.com:mespana/typo3-project2.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Set maximum releases backup
set('keep_releases', 5);

// To solve this issue: Cant't detect http user name. Please set up the 'http_user' config parameter.
set('http_user', 'www-data');
set('writable_mode', 'chmod');
set('use_relative_symlink', '0');

// Hosts
host('ftp109730-2622751@marianaespana.com')
->set('deploy_path', '~/www/marianaespana/proyectos/typo3-project2/');

//DocumentRoot / WebRoot for the TYPO3 automaticInstallation
set('typo3_webroot', 'public');

// Shared directories
set('shared_dirs', [
    '{{typo3_webroot}}/fileadmin',
    '{{typo3_webroot}}/typo3temp',
    '{{typo3_webroot}}/uploads'
]);

// Shared files
set('shared_files', [
    '{{typo3_webroot}}/.htaccess'
]);

// Writable dirs by web server
set('writable_dirs', [
    'config',
    'var',
    '{{typo3_webroot}}/fileadmin',
    '{{typo3_webroot}}/typo3temp',
    '{{typo3_webroot}}/typo3conf',
    '{{typo3_webroot}}/uploads'
]);

// Main TYPO3 Tasks
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy your project');
after('deploy', 'success');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');