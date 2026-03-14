<?php

class HomeController 
{
    /**
     * Show the homepage.
     * 
     * @param array $params Contains any URL parameters like {id}
     */
    public function index(array $params)
    {
        // Example logic:
        // $users = Database::query("SELECT * FROM users LIMIT 5");

        // Render the view
        View::render('index', [], 'main');
    }
}
