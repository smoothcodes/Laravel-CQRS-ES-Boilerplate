<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SmoothCode\Propagation\CommandBus;
use SmoothCode\Sample\Domain\Tutor\Command\CreateTutor;
use SmoothCode\Sample\Shared\ValueObjects\Email;
use SmoothCode\Sample\Shared\ValueObjects\Password;

class TutorController extends Controller
{
    public function create(Request $request, CommandBus $commandBus)
    {
        $valid = validator(
            $request->only('email', 'password'), [
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        if (!$valid->fails()) {
            $commandBus
                ->dispatch(
                    CreateTutor::fromPayload(
                        [
                            CreateTutor::EMAIL    => new Email('rusinowicz9@gmail.com'),
                            CreateTutor::PASSWORD => new Password('ce11c6dede')
                        ]
                    )
                );
        }
//
//        if ($valid->fails()) {
//            return Response::json(
//                \response()->json($valid->errors()->all(), 400)
//            );
//        }
//
//        $data = $request->only('name', 'email', 'password');
//
//        $user = User::create(
//            [
//                'name'     => $data['name'],
//                'email'    => $data['email'],
//                'password' => Hash::make($data['password'])
//            ]);
//
//        $account = new Account();
//
//        $user->account()->save($account);
//
//        $client = Client::where('password_client', 1)->first();
//
//        $request->request->add(
//            [
//                'grant_type'    => 'password',
//                'client_id'     => $client->id,
//                'client_secret' => $client->secret,
//                'username'      => $data['email'],
//                'password'      => $data['password'],
//                'scope'         => null,
//            ]);
//
//        $token = Request::create(
//            'oauth/token',
//            'POST'
//        );
//
//        dump($token);
//        return collect(
//            json_decode(\Route::dispatch($token)->getContent(), true)
//        )->merge(['user' => [
//            'id' => $user->id,
//            'name' => $user->name,
//            'email' => $user->email,
//            'account' => $user->account
//        ]]);
    }
}
