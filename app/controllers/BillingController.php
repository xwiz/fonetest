<?php

class BillingController extends BaseController {

    /**
     * Default constructor with authentication filters 
     */
    public function __construct() {
        $this->beforeFilter('auth', array('only'=>array('index')));
    }

	/**
	 * Page to show the user billing information
	 * @return Response
	 */
	public function index()
	{
        $start = 0;
        if(Input::has('page'))
        {
            $start = (Input::get('page') * 10) - 10;
        }
        $billinginfo = Billing::where('user_id', '=', Auth::user()->id)->get();
        
        require ('lib/fonenode.php');
        $fonenode = new fonenode('2f46146d', 'ovU0lIiwNcyC0zJW');
        $bills = $fonenode->list_bills(10, $start);
        $total = $bills['total'];
        $bills = $bills['data'];
        $bills = Paginator::make($bills, $total, 10);
        return View::make('pages.billing')->with('bills', $bills)->with('total', $total);
	}
}
