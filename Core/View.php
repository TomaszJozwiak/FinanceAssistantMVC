<?php

namespace Core;

class View
{
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/Views/$view";

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig_Environment($loader);
            $twig->addGlobal('current_user', \App\Auth::getUser());
            $twig->addGlobal('income_categories', \App\Controllers\Income::getUserIncomeCategories());
            $twig->addGlobal('expense_categories', \App\Controllers\Expense::getUserExpenseCategories());
            $twig->addGlobal('payment_method', \App\Controllers\Expense::getUserPaymentMethods());
            $twig->addGlobal('incomes', \App\Controllers\Balance::getIncomes());
            $twig->addGlobal('expenses', \App\Controllers\Balance::getExpenses());
            $twig->addGlobal('choosenDatePeriod', \App\Controllers\Balance::getDatePeriod());
            $twig->addGlobal('dateFrom', \App\Controllers\Balance::getDateFrom());
            $twig->addGlobal('dateTo', \App\Controllers\Balance::getDateTo());
            $twig->addGlobal('balance', \App\Controllers\Balance::getBalance());
            $twig->addGlobal('dataChart', \App\Controllers\Balance::getDataToChart());
            $twig->addGlobal('categoryCounter', \App\Controllers\Balance::getCategoryCounter());
            $twig->addGlobal('flash_messages', \App\Flash::getMessages());
            $twig->addGlobal('flash_errors', \App\Flash::getErrors());
        }
        echo $twig->render($template, $args);
    }
}
