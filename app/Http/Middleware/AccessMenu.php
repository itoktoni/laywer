<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AccessMenu {

	function __construct() {

	}

	public function validasi($sharing) {

		$uri = request()->segments()[0];
		$module = request()->segments()[1];

		$routeArray = app('request')->route()->getAction();
		if (isset($routeArray['controller'])) {
			$controllerAction = class_basename($routeArray['controller']);
			list($controller, $action) = explode('@', $controllerAction);
			view()->share('template', snake_case(str_replace_last('Controller', '', $controller)));
			view()->share('route', $module . '_' . $action);
		}

		view()->share('form', $module);
		view()->share('field', $module . '_');

		if (request()->segments()[1] == 'home') {
			return true;
		} else {
			if (empty(Route::currentRouteName())) {
				$module = $sharing->contains('action_controller', ucfirst(camel_case($uri)));
				if ($module) {
					return true;
				} else {
					return false;
				}
			} else {
				$mod = $sharing->where('module_code', $module);
				//session()->forget(['create', 'delete', 'update', 'read', 'export','print','admin']);

				session()->forget('akses');
				// session()->forget('button');

				if (count($mod) > 0) {
					foreach ($mod as $m) {
						session()->put('akses.' . $m->action_function, true);
					}

					$akses = array();
					foreach (session()->get('akses') as $m => $value) {
						View::share($m, true);
					}

				}
				// dd($mod);
				// dd(session()->get('akses'));

				$action = $sharing->contains('action_code', Route::currentRouteName());
				$ac = explode('@', Route::currentRouteAction());

				view()->share('action', $ac[1]);

				if ($action) {
					return true;
				} else {
					return false;
				}
			}
		}
	}

	public function getData() {
		if (Cache::has(Auth::user()->username . '_access_menu')) {
			$sharing = Cache::get(Auth::user()->username . '_access_menu');
		} else {
			$sharing = Cache::remember(Auth::user()->username . '_access_menu', 120, function () {
				return DB::table('actions')
					->leftJoin('module_connection_action', 'actions.action_code', '=', 'module_connection_action.conn_ma_action')
					->leftJoin('modules', 'module_connection_action.conn_ma_module', '=', 'modules.module_code')
				// ->leftJoin('modules', 'actions.action_module', '=', 'modules.module_code')
					->leftJoin('group_module_connection_module', 'group_module_connection_module.conn_gm_module', '=', 'modules.module_code')
					->leftJoin('group_modules', 'group_modules.group_module_code', '=', 'group_module_connection_module.conn_gm_group_module')
					->leftJoin('group_user_connection_group_module', 'group_user_connection_group_module.conn_gu_group_module', '=', 'group_modules.group_module_code')
					->where('conn_gu_group_user', Auth::user()->group_user)
					->where('module_enable', '1')
					->orderBy('group_module_sort', 'desc')
					->orderBy('module_sort', 'desc')
					->orderBy('action_sort', 'desc')
					->get();
			});
		}

		return $sharing;
	}

	public function setData($sharing) {
		if (session()->has(Auth::User()->username . '_group_access')) {
			$getGroup = session(Auth::User()->username . '_group_access');
		} elseif (!empty(collect($sharing)->first()->group_module_code)) {
			$getGroup = collect($sharing)->first()->group_module_code;
		} else {
			$getGroup = 'home';
		}

		$group_list = collect($sharing)->unique('group_module_code');
		View::share('group_list', $group_list);
		$action_list = collect($sharing)->where('group_module_code', $getGroup);
		View::share('action_list', $action_list);
		$menu_list = collect($sharing)->where('group_module_code', $getGroup)->unique('module_code');
		View::share('menu_list', $menu_list);

	}

	public function handle($request, Closure $next) {

		$data = $this->getData();
		$valid = $this->validasi($data);
		if (!$valid) {

			// abort(404, 'Unauthorized Action for This Pages !' );
			//return view('backend.' . config('website.backend') . '.' . '.errors.403');
		}
		$this->setData($data);

		return $next($request);
	}

}
