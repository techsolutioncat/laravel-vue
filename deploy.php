<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'emerge_production');

// Project repository
set('repository', 'git@bitbucket.org:ikebeitz/emergeweb.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false); 

// Shared files/dirs between deploys 
set('shared_files', []);
set('shared_dirs', []);

// Writable dirs by web server 
set('writable_dirs', []);


// Hosts

host('web.cspemerge.mobi')
    ->stage('dev')
    ->user('ec2-user')
    ->port(22)
    ->identityFile('~/.ssh/id_rsa')
    ->multiplexing(false)
    ->set('deploy_path', '~/{{application}}');    
    

// Tasks

desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

after('deploy:shared', 'overwrite-env');

after('deploy:writable', 'chmod');

desc('shared/.envを.env.{stage}で上書き');
task('overwrite-env', function () {
    $stage = get('stage');
    $src = ".env.${stage}";
    $deployPath = get('deploy_path');
    $sharedPath = "${deployPath}/shared";
    run("cp -f {{release_path}}/${src} ${sharedPath}/.env");
    run("cp -f {{release_path}}/${src} {{release_path}}/.env");
});

desc('storageとbootstrapsを777で権限を付与');
task('chmod', function () {
    run("sudo chmod -R 777 {{release_path}}/storage {{release_path}}/bootstrap");
});
