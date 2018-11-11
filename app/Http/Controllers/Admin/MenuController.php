<?php

namespace App\Http\Controllers\Admin;

use App\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $menu = Menu::firstOrFail();

        echo "<ul>";

        foreach (json_decode($menu->content) as $key => $item) {
            echo "<li>";

            if (isset($item->url) && !empty($item->url)) {
                echo "<a href='{$item->url}'>{$item->name}</a>";
            } else {
                echo $item->name;
            }

            if (!empty($item->children[0])) {
                echo "<ul>";

                foreach ($item->children[0] as $subKey => $subItem) {
                    echo "<li>";
                    if (isset($subItem->url)) {
                        echo "<a href='{$subItem->url}'>{$subItem->name}</a>";
                    } else {
                        echo $subItem->name;
                    }
                    echo "</li>";
                }

                echo "</ul>";
            }
            
            echo "</li>";
        }

        echo "</ul>";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('core.admin.menu.edit')->with('menu', Menu::first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $menu = Menu::first() ?? new Menu;
        
        $menu->content = json_encode(json_decode($request->hidden_menu)[0]);

        $menu->save();

        $menu->rebuild();

        return redirect(route('admin.menu.edit'))->with('menu', $menu)->with('success', "Menu saved");
    }
}
