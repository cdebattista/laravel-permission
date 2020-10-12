<?php
namespace Cdebattista\LaravelPermission\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Laravel\Jetstream\Jetstream;
use App\Models\Permission;
use App\Models\Group;
use App\Models\User;
use Cdebattista\LaravelPermission\Contracts\CreatesPermission;
use Cdebattista\LaravelPermission\Contracts\CreatesGroup;
use Cdebattista\LaravelPermission\Contracts\CreatesUser;

use Artisan, DB;

class InstallCommand extends Command{

    /**
     * @var bool
     *
     */
    protected $hidden = true;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:install {stack : The development stack that should be installed} {--seed= : Seed database for development} {--skip= : skip composer and npm run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Permission components and resources';

    /**
     * @var \string[][]
     */
    protected $permissions = [
        ['name' => 'Administrator', 'group' => 'Administration', 'slug' => 'administrator'],
        ['name' => 'Logs', 'group' => 'Debugger', 'slug' => 'logs'],

        ['name' => 'View users', 'group' => 'Users', 'slug' => 'view_user'],
        ['name' => 'Create users', 'group' => 'Users', 'slug' => 'create_user'],
        ['name' => 'Edit users', 'group' => 'Users', 'slug' => 'edit_user'],
        ['name' => 'Delete users', 'group' => 'Users', 'slug' => 'delete_user'],

        ['name' => 'View groups', 'group' => 'Groups', 'slug' => 'view_group'],
        ['name' => 'Create groups', 'group' => 'Groups', 'slug' => 'create_group'],
        ['name' => 'Edit groups', 'group' => 'Groups', 'slug' => 'edit_group'],
        ['name' => 'Delete groups', 'group' => 'Groups', 'slug' => 'delete_group'],

        ['name' => 'View permissions', 'group' => 'Permissions', 'slug' => 'view_permission'],
        ['name' => 'Create permissions', 'group' => 'Permissions', 'slug' => 'create_permission'],
        ['name' => 'Edit permissions', 'group' => 'Permissions', 'slug' => 'edit_permission'],
        ['name' => 'Delete permissions', 'group' => 'Permissions', 'slug' => 'delete_permission'],
    ];

    /**
     * @var \string[][]
     */
    protected $groups = [
        ['name' => 'Administration', 'group' => 'Administration'],
        ['name' => 'Debugger', 'group' => 'Administration'],
        ['name' => 'Users', 'group' => 'Users'],
        ['name' => 'Groups', 'group' => 'Groups'],
        ['name' => 'Permissions', 'group' => 'Permissions']
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->callSilent('vendor:publish', ['--tag' => 'permission-config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'permission-migrations', '--force' => true]);

        // Install Stack...
        if ($this->argument('stack') === 'livewire') {
            // todo
        } elseif ($this->argument('stack') === 'inertia') {
            $this->installInertiaStack();
        }
        if($this->option('seed')){
            $this->truncate(new User());
            $this->createUser([
                'lastname' => 'Demo',
                'firstname' => 'Stration',
                'email' => 'demo@demo',
                'password' => 'azertyui',
                'password_confirmation' => 'azertyui',
                'user_permissions' => [],
                'user_groups' => []
            ]);
        }
    }


    /**
     *
     */
    public function installInertiaStack()
    {
        if(!$this->option('skip')){
            (new Process([
                'composer',
                'require',
                'tightenco/ziggy',
                'doctrine/dbal'
            ], base_path()))->setTimeout(null)->run(function($type, $output){
                    $this->output->write($output);
                });

            $this->updateNodePackages(function($packages){
                return [
                           'vue-multiselect' => '^2.1.6',
                           'webpack-shell-plugin' => '^0.5.0',
                           'laravel-permission' => '^1.0.2'
                       ] + $packages;
            });

            // Generate routes
            Artisan::call('ziggy:generate resources/js/route.js');
        }


        // Webpack
        copy(__DIR__.'/../../stubs/webpack.mix.js', base_path('webpack.mix.js'));

        // Ensure directory exists
        (new Filesystem)->ensureDirectoryExists(app_path('Actions/Permission'));
        (new Filesystem)->ensureDirectoryExists(app_path('Policies'));

        // Models...
        copy(__DIR__.'/../../stubs/app/Models/Permission.php', app_path('Models/Permission.php'));
        copy(__DIR__.'/../../stubs/app/Models/Group.php', app_path('Models/Group.php'));
        copy(__DIR__.'/../../stubs/app/Models/GroupPermission.php', app_path('Models/GroupPermission.php'));
        copy(__DIR__.'/../../stubs/app/Models/UserPermission.php', app_path('Models/UserPermission.php'));
        if(Jetstream::hasTeamFeatures()){
            copy(__DIR__.'/../../stubs/app/Models/UserWithTeam.php', app_path('Models/User.php'));
        }else{
            copy(__DIR__.'/../../stubs/app/Models/User.php', app_path('Models/User.php'));
        }
        // Actions...
        copy(__DIR__.'/../../stubs/app/Actions/Permission/CreatePermission.php', app_path('Actions/Permission/CreatePermission.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Permission/UpdatePermission.php', app_path('Actions/Permission/UpdatePermission.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Permission/DeletePermission.php', app_path('Actions/Permission/DeletePermission.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Permission/CreateGroup.php', app_path('Actions/Permission/CreateGroup.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Permission/UpdateGroup.php', app_path('Actions/Permission/UpdateGroup.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Permission/DeleteGroup.php', app_path('Actions/Permission/DeleteGroup.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Permission/CreateUser.php', app_path('Actions/Permission/CreateUser.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Permission/UpdateUser.php', app_path('Actions/Permission/UpdateUser.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Permission/DeleteUser.php', app_path('Actions/Permission/DeleteUser.php'));
        if(Jetstream::hasTeamFeatures()){
            copy(__DIR__.'/../../stubs/app/Actions/Fortify/CreateNewUserWithTeam.php', app_path('Actions/Fortify/CreateNewUser.php'));
        }else{
            copy(__DIR__.'/../../stubs/app/Actions/Fortify/CreateNewUser.php', app_path('Actions/Fortify/CreateNewUser.php'));
        }
        copy(__DIR__.'/../../stubs/app/Actions/Fortify/UpdateUserProfileInformation.php', app_path('Actions/Fortify/UpdateUserProfileInformation.php'));

        // Policies...
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Policies', app_path('Policies'));

        // Blade views
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/views/auth', resource_path('views/auth'));

        // Inertia pages...
        copy(__DIR__.'/../../stubs/inertia/resources/js/Layouts/AppLayout.vue', resource_path('js/Layouts/AppLayout.vue'));
        copy(__DIR__.'/../../stubs/inertia/resources/js/app.js', resource_path('js/app.js'));
        copy(__DIR__.'/../../stubs/inertia/resources/css/app.css', resource_path('css/app.css'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/inertia/resources/js/InertiaTable', resource_path('js/InertiaTable'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/inertia/resources/js/Pages/Permission', resource_path('js/Pages/Permission'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/inertia/resources/js/Pages/Group', resource_path('js/Pages/Group'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/inertia/resources/js/Pages/Profile', resource_path('js/Pages/Profile'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/inertia/resources/js/Pages/User', resource_path('js/Pages/User'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/inertia/resources/js/Permission', resource_path('js/Permission'));


        $this->seedPermissions();
        $this->seedGroups();
        $this->createAdminUser();

    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Truncate table to reset index
     * @param $model
     */
    public function truncate($model){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $model->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Ask to reset permissions table
     * @return bool
     */
    public function resetPermissions(){
        $permissions = new Permission();
        if($permissions->count()){
            if ($this->confirm('Reset and seed permissions table ?')) {
                $permissions->query()->delete();
                $this->truncate($permissions);
                return true;
            }
        }
        return false;
    }

    /**
     * Seed permissions table
     */
    public function seedPermissions(){
        $permissions = new Permission();
        if($this->resetPermissions() || !$permissions->count()){
            foreach($this->permissions as $permission){
                app(CreatesPermission::class)->create($permission);
            }
        }
    }

    /**
     * Ask to reset groups table
     * @return bool
     */
    public function resetGroups(){
        $groups = new Group();
        if($groups->count()){
            if ($this->confirm('Reset and seed groups table ?')) {
                $groups->query()->delete();
                $this->truncate($groups);
                return true;
            }
        }
        return false;
    }

    /**
     * Seed groups table
     */
    public function seedGroups(){
        $groups = new Group();
        if($this->resetGroups() || !$groups->count()){
            $permissions = new Permission();
            foreach($this->groups as $group){
                app(CreatesGroup::class)->create([
                    'name' => $group['name'],
                    'group' => $group['group'],
                    'group_permissions' => collect($permissions->optGroup())->where('group', $group['name'])->pluck('options')->first()
                ]);
            }
        }
    }

    /**
     * Create a user with administration permissions to be allowed to go on users, groups and permissions pages.
     */
    public function createAdminUser(){
        if ($this->confirm('Do you want to create an admin user ?')) {
            $user = new User();
            if($user = $user->firstWhere('email', 'admin@admin')){
                $this->info('Delete previous Admin user');
                $user->delete();
            }
            $permission = new Permission();
            $permission = $permission->firstWhere('slug', 'administrator')->id;
            $password = Str::random(8);
            $this->createUser([
                'lastname' => 'Admin',
                'firstname' => 'Istration',
                'email' => 'admin@admin',
                'password' => $password,
                'password_confirmation' => $password,
                'user_permissions' => [['id' => $permission]],
                'user_groups' => []
            ]);
            $this->info('Admin user created !');
            $this->info('Password : ' . $password);
        }else{
            $this->alert('Note : you need to have administrator permission to access to users, groups and permissions pages !');
            $user = new User();
            if($user->count()){
                if ($this->confirm('Do you want add administrator permission to one user ?')) {
                    $user_id = $this->ask('What is your user ID ?');
                    if($user = $user->find($user_id)){
                        $permission = new Permission();
                        $permission = $permission->firstWhere('slug', 'administrator')->id;
                        $user->permissions()->sync($user->permissions->pluck('id')->push($permission));
                        $this->info($user->email .  ' is now Admin !');
                    }else{
                        $this->warn('User not found ! Please retry !');
                    }
                }
            }else{
                $this->warn('There are not users in database ! Don\'t forget to add permissions to users later !');
            }
        }
    }

    /**
     * Create user
     * @param $input
     */
    public function createUser($input){
        app(CreatesUser::class)->create($input);
    }
}