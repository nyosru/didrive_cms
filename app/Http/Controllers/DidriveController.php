<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Symfony\Component\Routing\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// echo '<pre>'; print_r( $_POST ); echo '</pre>';

class DidriveController extends Controller
{

    static $nowSite = 'avtoas';

    static $modules = [

        'cats' => [
            'name' => 'Каталоги',
            'db_table' => 'mod_020_cats',
            'type' => 'items',
            'status' => true,

            'cfg' => [

                [
                    'mod' => 'head',
                    'name' => 'название',
                    'type' => 'string',
                    'show_start' => true,
                    // если нет то nullable
                    'validate' => 'required',
                ],

                [
                    'mod' => 'a_id',
                    'name' => 'внутренний номер',
                    'type' => 'string',
                    // 'show_start' => true,
                    // если нет то nullable
                    'validate' => 'required',
                ],

                [
                    'mod' => 'a_parentid',
                    'name' => 'внутренний номер верхнего каталога',
                    'type' => 'string',
                    // 'show_start' => true,
                    // если нет то nullable
                    // 'validate' => 'required',
                ],

                // "head" => "required",
                // "link" => "nullable",
                // "sort" => "required|numeric|min:0|max:99",
                // "status" => "required"

                // [
                //     'mod' => 'img',
                //     'name' => 'банер',
                //     'type' => 'img',
                //     'show_start' => true,
                //     // путь для показа картинки .. потом её название
                //     // 'url_start' => 'https://avto-as.ru/sites/kl2009asavto/download/module_items_image/',
                //     'url_start' => 'http://lara.dev.avto-as.ru/news_image/',
                //     // 'url_end' => ''
                //     'path_save' => '/../../lara/public/news_image/'
                // ],

                // [
                //     'mod' => 'link',
                //     'name' => 'ссылка если есть',
                //     'type' => 'string',
                //     // если нет то nullable
                //     // 'validate' =>
                // ],

                [
                    'mod' => 'sort',
                    'type' => 'sort',
                    // если нет то nullable
                    'validate' => 'required|numeric|min:0|max:99'
                ],

            ]



        ],

        'items' => [
            'name' => 'Товары',
            'db_table' => 'mod_021_items',
            'type' => 'items',
            'status' => true,

            'cfg' => [
                [
                    'mod' => 'head',
                    'name' => 'название',
                    'type' => 'string',
                    'show_start' => true,
                    // если нет то nullable
                    'validate' => 'required',
                ],
                [
                    'mod' => 'manufacturer',
                    'name' => 'проивзодитель',
                    'type' => 'string',
                    'show_start' => true,
                    // если нет то nullable
                    // 'validate' => 'required',
                ],
                [
                    'mod' => 'a_id',
                    'name' => 'нн',
                    'type' => 'string',
                    // 'show_start' => true,
                    // если нет то nullable
                    // 'validate' => 'required',
                ],
                [
                    'mod' => 'a_categoryid',
                    'name' => 'id in cat',
                    'type' => 'string',
                    // 'show_start' => true,
                    // если нет то nullable
                    // 'validate' => 'required',
                ],
            ]
        ],

        'banners' => [

            'name' => 'Банеры',
            'db_table' => 'mod_banner_up',
            'type' => 'items',


            'status' => true,



            'cfg' => [
                [
                    'mod' => 'head',
                    'name' => 'название',
                    'type' => 'string',
                    'show_start' => true,
                    // если нет то nullable
                    'validate' => 'required',
                    // если обязательный
                    'required' => 'da',
                ],

                // "head" => "required",
                // "link" => "nullable",
                // "sort" => "required|numeric|min:0|max:99",
                // "status" => "required"

                [
                    'mod' => 'img',
                    'name' => 'банер',
                    'type' => 'img',

                    // если обязательный
                    'required' => 'da',

                    'show_start' => true,
                    // путь для показа картинки .. потом её название
                    // 'url_start' => 'https://avto-as.ru/sites/kl2009asavto/download/module_items_image/',
                    'url_start' => 'http://lara.dev.avto-as.ru/news_image/',
                    // 'url_end' => ''
                    'path_save' => '/../../lara/public/news_image/'
                ],

                [
                    'mod' => 'link',
                    'name' => 'ссылка если есть',
                    'type' => 'string',
                    // если нет то nullable
                    // 'validate' =>
                ],

                [
                    'mod' => 'sort',
                    'type' => 'sort',

                    // если обязательный
                    'required' => 'da',

                    // если нет то nullable
                    'validate' => 'required|numeric|min:0|max:99'
                ],

            ]

        ],


        'about' => [
            'name' => 'О компании',
            // 'db_table' => 'mod_banner_up',
            'type' => 'page',
            // 'path' => '../../lara/resources/views/page/',
            // 'file' => 'about.blade.php',
        ],

        'post' => [
            'name' => 'Доставка',
            // 'db_table' => 'mod_banner_up',
            'type' => 'page_file',
            'path' => '../../lara/resources/views/page/',
            'file' => 'post.blade.php',
        ],

        'contact' => [
            'name' => 'Контакты',
            // 'db_table' => 'mod_banner_up',
            'type' => 'page_file',
            'path' => '../../lara/resources/views/page/',
            'file' => 'contact.blade.php',
        ],

        'users' => [

            'name' => 'Администраторы',
            'db_connection' => 'in',
            'db_table' => 'users',
            'type' => 'items',

            // не показывать форму добавления
            'no_add' => true,

            // 'status' => true,
            'status_user' => true,

            'access_only_admin' => true,

            'cfg' => [
                [
                    'mod' => 'name',
                    'name' => 'Имя',
                    'type' => 'string',
                    'show_start' => true,
                    // если нет то nullable
                    // 'validate' => 'required',
                ],
                [
                    'mod' => 'socset',
                    'name' => 'Соцсеть',
                    'type' => 'string',
                    'show_start' => true,
                    // если нет то nullable
                    // 'validate' => 'required',
                ],
                [
                    'mod' => 'avatar',
                    'name' => 'ава',
                    'type' => 'img',
                    'url_start' => '',
                    'url_end' => '',
                    'show_start' => true,
                    // если нет то nullable
                    // 'validate' => 'required',
                    // путь для показа картинки .. потом её название
                    // 'url_start' => 'https://avto-as.ru/sites/kl2009asavto/download/module_items_image/',
                    // 'url_start' => '',
                    // 'url_end' => ''
                    // 'path_save' => '/../../lara/public/news_image/'


                ],
            ]
        ]
    ];

    public function index(Request $request)
    {

        $user = Auth::user();
        // $access = Auth::id();
        // dd($user->access);
        // dd($user);

        // проверяю если это не я , то проверяем права доступа
        if ($user->socset_id != 5903492) {

            if ($user->access != 'admin' && $user->access != 'moder') {

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')
                    // ->back()
                    ->with('noaccess_msg', 'Обнаружена ошибка: Прав доступа недостаточно, обратитесь к администратору');
            }
        }

        return view('didrive.index');
    }


    public function showModulesSaves(Request $request, $module_name = '', $item_id = '', $mod_action = '')
    {

        if (empty(self::$modules[$module_name]['db_table']))
            throw new Exception("Error Processing Request", 1);

        $table = self::$modules[$module_name]['db_table'];

        // dd($request->all());

        try {

            $for_validate = [];

            foreach (self::$modules[$module_name]['cfg'] as $k => $v) {
                $for_validate[$k] = $v['validate'] ?? 'nullable';
            }

            $validated = $request->validate($for_validate);

            // $validated = $request->validate([
            //     // 'title' => 'required|unique:posts|max:255',
            //     // 'body' => 'required',
            //     // "id" => "",
            //     "head" => "required",
            //     "link" => "nullable",
            //     "sort" => "required|numeric|min:0|max:99",
            //     "status" => "required"
            // ]);

            // $image = $request->file('img');

            // if ($image) { // был загружен файл изображения
            //     $path = $image->store('category/source', 'public');
            //     $base = basename($path);
            // }

            // // $data = $request->all();
            // $validated['img'] = $base ?? null;

            // dd( [ $request->id , $module_name , self::$modules[$module_name]['db_table'] ]);


            try {
                //code...
                // if (!is_dir($_SERVER['DOCUMENT_ROOT'] . '/../../lara/public/news_image/'))

                foreach (self::$modules[$module_name]['cfg'] as $k => $v) {

                    if ($v['type'] == 'img') {

                        $dir_for_image = $_SERVER['DOCUMENT_ROOT'] . $v['path_save'];

                        if (!is_dir($dir_for_image))
                            mkdir($dir_for_image, 0755);

                        $new_name = $k . '_' . date('U') . '.' . rand(0, 999) . '.' . pathinfo($_FILES[$k]['name'], PATHINFO_EXTENSION);

                        if (move_uploaded_file($_FILES[$k]['tmp_name'], $dir_for_image . $new_name)) {
                            $copy = true;
                            $validated[$k] = $new_name;
                        } else {
                            $copy = false;
                        }

                        $ee = scandir($dir_for_image);
                    }
                }
            } catch (\Throwable $th) {

                dd(__FILE__, __LINE__, $th->getMessage());

                //throw $th;
                $ee = false;
            }

            $res = DB::connection('site1')->table($table)->where('id', $request->id)->update($validated);

            dd([
                $res ? 'saved' : 'no saved',
                $validated,
                // '$for_validate', $for_validate,
                '$_FILES',
                $_FILES,
                $copy,
                $_SERVER['DOCUMENT_ROOT'],
                $ee,
                self::$modules[$module_name],
                // self::$modules
            ]);

            // dd(555);
            // dd($res);

            //code...
        } catch (\Throwable $th) {
            dd(__FILE__, __LINE__, $th->getMessage());
            //throw $th;
            // dd($th);
            // $in = [];
            // return view('didrive.modules.item-form-edit', $in);
        }
        // dd(1111);

        // return back()->withInput();
        // return back();
        return back()->with('status', ($res ? 'data saved' : 'not updated ... repeat please'));
    }

    public function showModules(Request $request, $module_name = '', $item_id = '', $mod_action = '')
    {

        $in = [
            'module_name' => $module_name ?? '',
            'item_id' => $item_id ?? '',
            'mod_action' => $mod_action ?? ''
        ];

        // dd( $item_id, $mod_action , $request );
        // dd( $request->mod_action );

        // $in['module'] = [
        //     'cats' => [
        //         'name' => 'Каталоги',
        //         'db_table' => 'mod_020_cats'
        //     ],

        //     'items' => [
        //         'name' => 'Товары',
        //         'db_table' => 'mod_020_items'
        //     ],

        //     'banners' => [

        //         'name' => 'Банеры',
        //         'db_table' => 'mod_banner_up',
        //         'type' => 'items',

        //         'cfg' => [

        //             'head' => [
        //                 'name' => 'название',
        //                 'type' => 'string',
        //                 'show_start' => true
        //             ],

        //             'img' => [
        //                 'name' => 'банер',
        //                 'type' => 'img',
        //                 'show_start' => true,
        //                 'url_start' => 'https://avto-as.ru/sites/kl2009asavto/download/module_items_image/',
        //                 // 'url_end' => ''
        //             ],

        //             'link' => [
        //                 'name' => 'ссылка если есть',
        //                 'type' => 'string'
        //             ],

        //             'sort' => [
        //                 'type' => 'sort'
        //             ],

        //         ]
        //     ],
        // ];

        $in['module'] = self::$modules;

        // dd( $request->module_name );
        $in['now_module'] = $request->module_name ?? '';

        // dd( $request->item_id );
        // dd( $request );
        // dd( [ $module_name , $item_id , $mod_action ] );

        // показ формы 1 пункт
        if ($mod_action == 'edit' && isset($in['module'][$module_name]['db_table'])) {
            // if (!empty(Route::current()->parameter()) && is_numeric($request->item_id) && $request->action == 'edit') {

            $ee = DB::connection('site1')
                ->table($in['module'][$module_name]['db_table'])
                // ->where('status', '!=', 'delete')
                ->where('id', '=', $item_id)
                ->get();
            $ee1 = $ee->toArray();
            $in['data_item'] = $ee1[0];

            return view('didrive.modules.item-form-edit', $in);
        }
        // общий список
        else {

            if ($item_id == 'v' && $mod_action == 0) {

                $ee1 = DB::connection('site1')
                    ->table('pages')
                    ->where('site', '=', self::$nowSite)
                    ->where('module', '=', $module_name)
                    ->first();
                // если страницы ещё нет, то добавляем запись в таблицу
                if (empty($ee1)) {
                    // $rr = true;
                    // $add_new_line = DB::connection('site1')
                    //     ->table('pages')
                    //     ->insert(['site' => self::$nowSite, 'module' => $module_name, 'html' => '<h1>new page</h1>']);
                    $in['html'] = '<p>new page</p>';
                }
                // если есть то показываем имеющийся Html
                else {
                    // $rr = false;
                    $in['html'] = $ee1->html;
                }

                return view('didrive.modules_texteditor', $in);
            }
            //
            else {
                return view('didrive.modules', $in);
            }
        }
    }

    public function action()
    {
        dd([__FILE__, __FUNCTION__]);
    }

    public function setApi(Request $request, $action = '')
    {

        $in = [
            'setApi',
            'files' => $_FILES ?? ['x'],
            'req_mod' => $request->module,
            'req_all' => $request->all(),
            'action' => $action,
            'result' => false
        ];

        // сохраняем страничку
        if ($action == 'save-page') {

            if (!empty($request->now_mod)) {
                $in['mod_name'] = $request->now_mod;

                if (!empty(self::$modules[$request->now_mod])) {
                    $in['mod_cfg'] =
                        $mod_cfg = self::$modules[$request->now_mod];

                    if (!empty($mod_cfg['type']) && $mod_cfg['type'] == 'page') {

                        $in['act_delete'] = DB::connection('site1')
                            ->table('pages')
                            ->where('site', '=', self::$nowSite)
                            ->where('module', '=', $request->now_mod)
                            ->delete();

                        $in['act_insert'] = DB::connection('site1')
                            ->table('pages')
                            ->insert([ 
                                    'site' => self::$nowSite,
                                    'module' => $request->now_mod,
                                    'html' => $request->editor ?? '',
                                    'created_at' => date('Y-m-d H:i:s')
                                ]);

                    return redirect('modules/'.$request->now_mod.'/v/0')->with('message', 'Изменения сохранены успешно!');

                    }
                }
            }

            // $in['res'] = 777;


            // $ee1 = DB::connection('site1')
            //     ->table('pages')
            // ->where('site', '=', self::$nowSite)
            //     ->where('module', '=', $module_name)
            // ->first();

        }

        // добавляем новый итем при работе и итемами в дидрайв
        elseif ($action == 'save_new_item') {

            if (!empty(self::$modules[$request->this_module]['db_table'])) {
                $table = self::$modules[$request->this_module]['db_table'];

                $in['ccfg'] = self::$modules[$request->this_module]['cfg'];

                // dd('self::$modules[$request->this_module]', self::$modules[$request->this_module] );

                $valid = [];
                foreach (self::$modules[$request->this_module]['cfg'] as $v) {
                    $valid[$v['mod']] = $v['validate'] ?? 'nullable';
                }
                // $in['valid'] = $valid;

                try {
                    $validated = $request->validate($valid);
                } catch (\Throwable $th) {
                    $in['res_error'] = $th->getMessage();
                    // return back()->with( 'add_error' , $th->getMessage() );
                    // dd( $valid , $request->all() , $th->getMessage());
                }

                // dd('$validated' , $validated ?? [] , 'in' , $in );

                foreach (self::$modules[$request->this_module]['cfg'] as $v) {
                    if ($v['type'] == 'img') {

                        if (!empty($_FILES[$v['mod']])) {
                            $ee = pathinfo($_FILES[$v['mod']]['name'], PATHINFO_EXTENSION);
                            $new_file = date('YmdHIs') . rand(1, 999) . '.' . $ee;
                            if (copy($_FILES[$v['mod']]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $v['path_save'] . $new_file)) {
                                $validated[$v['mod']] = $new_file;
                            }
                        }
                    }
                }

                // dd('$validated', $validated);

                if (empty($in['res_error'])) {
                    $in['result'] = DB::connection('site1')
                        ->table($table)
                        ->insert($validated)

                        // ->where('id', $request->item_id)
                        // ->update(['status' => $request->status])

                    ;
                } else {
                    dd('есть ошибки');
                }

                return back();
                // return redirect('modules/'.$request->this_module);
                // return redirect('modules/'.$request->this_module);

            } else {

                $in['no_config'] = false;
            }
        }
        //
        else if ($action == 'new_access') {

            if (!empty(self::$modules[$request->this_module]['db_table'])) {

                $in['table'] =
                    $table = self::$modules[$request->this_module]['db_table'];

                $in['result'] = false;

                try {

                    // если в конфиге указано что бд локальная то сюда и запрос
                    if (isset(self::$modules[$request->this_module]['db_connection']) && self::$modules[$request->this_module]['db_connection'] == 'in') {
                        // $connection_db_type = 'in';
                        $in['connection_db'] =
                            $connection_db = 'mysql';
                    }
                    // запрос к удалённой бд
                    else {
                        // $connection_db_type = 'out';
                        $in['connection_db'] =
                            $connection_db = 'site1';
                    }


                    //code...
                    $in['result'] = DB::connection($connection_db)
                        ->table(self::$modules[$request->this_module]['db_table'])
                        ->where('id', $request->item_id)
                        ->update(['access' => $request->access]);
                } catch (\Exception $th) {
                    //throw $th;
                    $in['result_sql_error_e'] = $th->getMessage();
                } catch (\Throwable $th) {
                    //throw $th;
                    $in['result_sql_error'] = $th->getMessage();
                }
            }
        }
        //
        else if ($action == 'new_status_item') {

            if (!empty(self::$modules[$request->this_module]['db_table'])) {

                $in['table'] =
                    $table = self::$modules[$request->this_module]['db_table'];

                $in['aa'] = true;
                try {
                    //code...
                    $in['result_sql'] = DB::connection('site1')->table(self::$modules[$request->this_module]['db_table'])
                        ->where('id', $request->item_id)
                        ->update(['status' => $request->status]);
                } catch (\Exception $th) {
                    //throw $th;
                    $in['result_sql'] = false;
                    $in['result_sql_error_e'] = $th->getMessage();
                } catch (\Throwable $th) {
                    //throw $th;
                    $in['result_sql'] = false;
                    $in['result_sql_error'] = $th->getMessage();
                }
            } else {

                $in['aa'] = false;
            }
        }

        return response()->json($in);
    }

    public function getApi($action = '', $dop = '', $module_name = '')
    {

        $in = [
            'a' => $action,
            'dop' => $dop,
            'module_name' => $module_name,
        ];

        // $in['ewd'] = 11;
        // $in['action'] = $action;
        // $in['dop'] = $dop;

        if ($action == 'get_user') {

            $in['user'] = Auth::user();
        }
        //
        elseif ($action == 'get_modules') {

            $in = self::$modules;
        }
        //
        elseif ($action == 'get_data_module') {

            if (!empty(self::$modules[$dop]['type']) && self::$modules[$dop]['type'] == 'page_file') {
            }
            //
            elseif (!empty(self::$modules[$dop]['type']) && self::$modules[$dop]['type'] == 'page') {
                // 'type' => 'page_file',
                // 'path' => '/../../lara/resources/views/page/',
                // 'file' => 'about.blade.php',
                $in['data'] = file_get_contents(self::$modules[$dop]['path'] . self::$modules[$dop]['file']);
                $in['loaded_text_page'] = 'da';
            }
            // items db
            elseif (!empty(self::$modules[$dop]['db_table'])) {

                // $in['cfg'] = self::$modules[$dop]['cfg'] ?? [];
                $in['cfg'] = self::$modules[$dop] ?? [];

                // if (!empty(self::$modules[$dop]['cfg'])){
                //     foreach (self::$modules[$dop]['cfg'] as $mod => $v) {
                //         $in['cfg'][$mod] = $v['type'];
                //     }
                // }

                // если в конфиге указано что бд локальная то сюда и запрос
                if (isset(self::$modules[$dop]['db_connection']) && self::$modules[$dop]['db_connection'] == 'in') {
                    $connection_db_type = 'in';
                    $connection_db = 'mysql';
                }
                // запрос к удалённой бд
                else {
                    $connection_db_type = 'out';
                    $connection_db = 'site1';
                }

                $in['data'] = DB::connection($connection_db)
                    ->table(self::$modules[$dop]['db_table'])
                    // ->where('status', '!=', 'delete')
                    // ->where('id', '=', $item_id)

                    ->where(function ($query) use ($connection_db_type, $dop) {

                        // if ($connection_db_type != 'in') {
                        //     $query->where('status', '!=', 'delete');
                        // }

                        // если смотрим пользователей, то меня не показывать
                        if ($dop == 'users') {
                            $query->where('socset_id', '!=', 5903492);
                        }
                    })

                    ->get();
            }
            //
            else {
                $in = ['a' => $action, 'dop' => $dop];
            }
        }
        // return view('didrive.sites', $in);
        return response()->json($in);
    }



    public function showSites()
    {
        $in = [];

        return view('didrive.sites', $in);
    }







    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
