<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\PocketProcessed;
use App\Http\Requests\PocketRequest;
use App\Models\Pocket;
use App\Services\AccountService;
use App\Services\PocketService;
use Illuminate\Http\Request;

class PocketController extends Controller
{
    public function __construct(
        private AccountService $accountService,
        private PocketService $pocketService
    ) {
    }

    public function index(Request $request)
    {
        $transactions = Pocket::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($transactions);
    }

    public function store(PocketRequest $request)
    {
        try {
            $accountUser = $this->accountService->getAccountByUser($request->user());

            if($accountUser->total < $request->amount){
                return response()->json([
                    'message' => 'Your current account doesn`t have enough money for create a pocket',
                ], 409);
            }

            $pocket = $this->pocketService->createPocket($request, $accountUser);

            return response()->json([
                'message' => 'Pocket was created successfuly',
                'pocket' => $pocket
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
                'trace' => $ex->getTrace()
            ]);
        }   
    }

    public function show(Pocket $pocket)
    {
        return response()->json($pocket);
    }

    public function destroy(Request $request, Pocket $pocket)
    {
        try {
            $pocket->delete();

            event(new PocketProcessed(
                $pocket,
                $this->accountService->getAccountByUser($request->user()),
                true
            ));

            return response()->json([
                'message' => 'Your pocket was deleted successfuly',
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
                'trace' => $ex->getTrace()
            ]);
        }
    }
}
