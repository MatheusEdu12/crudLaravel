<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View as ViewView;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProdutoController extends Controller
{
    public function index(): View
    {
        $produtos = Produto::latest(5);
        return view('produto.index', compact('produtos'))
            -> with('i', (request()->input('page',1)-1) * 5);
    }

    public function create(): View
    {
        return view('produtos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request -> validate([
            'descricao' => 'required',
            'quantidade' => 'required',
            'precoUnitario' => 'required',
            'precoVenda' => 'required',

        ]);
        Produto::create($request->all());

        return redirect()->route('produtos.index')
            ->with('Sucess', 'Produto criado com sucesso.');
    }

    public function show(Produto $produto): View
    {
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto): View
    {
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto): RedirectResponse
    {
        $request -> validate([
            'descricao' => 'required',
            'quantidade' => 'required',
            'precoUnitario' => 'required',
            'precoVenda' => 'required',

        ]);   
        $produto->update($request->all());

        return redirect()->route('produtos.index')
            ->with('Sucess', 'Produto alterado com sucesso.');
    }

    public function destroy(Produto $produto): RedirectResponse
    {
        $produto -> delete();
        return redirect()->route('produtos.index')
            ->with('Sucess', 'Produto excluído com sucesso.');
    }
}
