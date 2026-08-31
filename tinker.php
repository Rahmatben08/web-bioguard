
$request = request();
$request->merge(['show_demo' => 1]);
$response = app()->call('App\Http\Controllers\FleetController@liveLocation', ['request' => $request]);
echo json_encode($response->getData(true));
