<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\AbstractService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Contracts\View\View;

abstract class AbstractController extends Controller
{
    protected string $view;
    public function __construct(protected AbstractService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): View|string
    {
        try {
            $perPage = (int) $request->route('perPage', 10);
            $resources = $this->service->index($perPage, $request->all());

            return view($this->view, ['data' => $resources]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $resource = $this->service->show($id);

            return response()->json($resource);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function store()
    {
        try {
            $formRequest = $this->getRequestInstance('store');

            $validatedData = $formRequest->validated();

            $this->service->store($validatedData);

            return redirect()->route($this->view);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator, 'create')->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(int $id)
    {
        try {
            // Pega a instância correta do FormRequest
            $formRequest = $this->getRequestInstance('update');
    
            // Valida e obtém os dados
            $validatedData = $formRequest->validated();
    
            // Chama o serviço para atualizar os dados validados
            $this->service->update($id, $validatedData);
    
            return redirect()->route($this->view);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator, 'update')->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $this->service->delete($id);

            return redirect()->back();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Define qual FormRequest deve ser usado para o método store.
     * Este método deve ser implementado nas classes filhas.
     *
     * @return string
     */
    abstract protected function getStoreRequest(): string;

    /**
     * Define qual FormRequest deve ser usado para o método update.
     * Este método deve ser implementado nas classes filhas.
     *
     * @return string
     */
    abstract protected function getUpdateRequest(): string;

    /**
     * Pega o FormRequest correspondente antes de executar store e update.
     *
     * @param string $action
     * @return FormRequest
     */
    protected function getRequestInstance(string $action): FormRequest
    {
        $requestClass = $action === 'store'
            ? $this->getStoreRequest()
            : $this->getUpdateRequest();

        return app($requestClass);
    }

    /**
     * Handle exceptions and return a JSON response.
     *
     * @param Exception $e
     * @return JsonResponse
     */
    private function handleException(Exception $e): JsonResponse
    {
        return response()->json([
            'message' => $e->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
