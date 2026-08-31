$request = request();
$request->merge(['show_demo' => 0]);
$response = app()->call('App\Http\Controllers\DashboardController@liveData', ['request' => $request]);
echo json_encode($response->getData(true), JSON_PRETTY_PRINT);
