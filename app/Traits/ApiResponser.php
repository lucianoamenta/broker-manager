<?php
namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;

trait ApiResponser {
    
    protected function successResponse($message = null, $data = null, $code = Response::HTTP_OK) {
        if (is_array($message) && is_null($data)) {
            $data = ['data' => $message];
            $message = null;
        }

        $data_response = [
                'status' => true,
                'code' => $code,
        ];
        if(!is_null($message)){
         $data_response = array_merge($data_response, ['message' => $message]);   
        }
        if(is_array($data) && count($data)>0) {
            $data_response = array_merge($data_response, $data);
        }
        return response()->json($data_response, $code);
    }
    
    protected function errorResponse($message, $code = Response::HTTP_BAD_REQUEST, $data = null) {
        $response = [
            'status' => false, 
            'code' => $code, 
            'error' => $message
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
    
    protected function errorWalletNotFoundYet() {
        return response()->json([
            'status' => false, 
            'code' => 499, 
            'error' => 'Todavía no tenes disponible una cuenta. Esperá un tiempito más, ya que estamos verificando unos ultimos detalles de tus datos.'
        ], 499);
    }
    
    protected function errorValidatorResponse($errors) {
        return response()->json([
            'status' => false,
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'message' => 'The given data was invalid.',
            'errors' => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    
    protected function showOne(Model $instance, $code = Response::HTTP_OK) {
       return $this->successResponse(null, ['data' => $instance], $code);
    }

    protected function cacheRequest(callable $callback, int $minutes = 1) {
        $user = auth()->user();
        $userId = $user ? $user->uuid : 'guest';
        $url = request()->url();
        $queryParams = request()->query();
        
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl = "api_response:user_{$userId}:{$url}:{$queryString}";
        
        // Solo para debugging - ver header X-Cache
        $isCached = Cache::has($fullUrl);
        
        $response = Cache::remember($fullUrl, now()->addMinutes($minutes), function() use ($callback) {
            $data = $callback();
            
            // Si es una respuesta HTTP, agregamos header
            if ($data instanceof \Illuminate\Http\Response || $data instanceof \Illuminate\Http\JsonResponse) {
                $data->header('X-Cache', 'MISS');
            }
            
            return $data;
        });
        
        // Si viene del cache, agregamos header
        if ($isCached && ($response instanceof \Illuminate\Http\Response || $response instanceof \Illuminate\Http\JsonResponse)) {
            $response->header('X-Cache', 'HIT');
        }
        
        return $response;
    }

    protected function cachePublicRequest(callable $callback, int $minutes = 1, string $customKey = '') {
        $url = request()->url();
        $queryParams = request()->query();
        
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        
        // Puedes personalizar la clave o usar la generada automáticamente
        $cacheKey = $customKey ?: "api_public:{$url}:{$queryString}";
        
        $isCached = Cache::has($cacheKey);
        
        $response = Cache::remember($cacheKey, now()->addMinutes($minutes), function() use ($callback) {
            $data = $callback();
            
            if ($data instanceof \Illuminate\Http\Response || $data instanceof \Illuminate\Http\JsonResponse) {
                $data->header('X-Cache', 'MISS');
            }
            
            return $data;
        });
        
        if ($isCached && ($response instanceof \Illuminate\Http\Response || $response instanceof \Illuminate\Http\JsonResponse)) {
            $response->header('X-Cache', 'HIT');
        }
        
        return $response;
    }
    
    protected function paginate(Collection $collection, $perPage = 25) {
       $rules = [
           'per_page' => 'integer|min:10|max:100'
       ];

       Validator::validate(request()->all(), $rules);
       $page = LengthAwarePaginator::resolveCurrentPage();
       if (request()->has('per_page')) { $perPage = (int) request()->per_page; }
       $results = $collection->slice(($page - 1) * $perPage, $perPage) -> values();
       $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page,
       [ 'path' => LengthAwarePaginator::resolveCurrentPath(), ]);
       $paginated->appends(request()->all);
       return $paginated;
    }
    
    protected function showAll(Collection $collection, $code = 200) {
       if($collection->isEmpty()){ return $this->successResponse(null, ['data' => $collection], $code); }
       return $this->successResponse(null, ['data' => $collection], $code);
    }
    
    protected function showAllPaginate(Collection $collection, $code = 200) {
       if($collection->isEmpty()){ return $this->successResponse(null, ['data' => $collection], $code); }
       $collection = $this->paginate($collection);
       return $this->successResponse(null, ['data' => $collection], $code);
    }
}
