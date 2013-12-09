<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for curreny exchange rate.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Currency_model extends Base_model 
{
	//name of table
	protected $c_table = 'currency';
	
	private $default_currency;
	private $enabled_currencies_codes;
	
	/**
	 * Init currency default.
	 * 
	 * @return void
	 */
    public function __construct()
    {
        parent::__construct();
        
        $this->default_currency = $this->getDefaultCurrency();
        $this->enabled_currencies_codes = $this->getEnabledCurrenciesCodes(TRUE);
    }
    
    /**
     * Set currency for display prices.
     *
     * @param string $code
     */
    public function setCurrencyCode($code)
    {
    	if(!$this->isEnableCurrencyCode($code)) return FALSE;
    	
    	$sessdata['current_currency_code'] = $code;

		$this->session->set_userdata($sessdata);
		
		return TRUE;
    }
	
    /**
     * Return price depending from currency.
     *
     * @param float $price
     * @param bool $show_symbol (show $, &euro; etc)
     * @param char(3) $code (USD,EUR,UAH)
     * @return string
     */
    public function exchange($price,$show_symbol=TRUE,$code=FALSE)
    {
    	if(!$code) $code = $this->getCurrentCurrencyCode();
    	
    	$currency = $this->enabled_currencies_codes[$code];//get currency data
    	
    	if( $code!=$this->default_currency['code'] ) //do exchange
    	{
    		$price = ($price/$this->default_currency['exchange_rate'])*$currency['exchange_rate'];
    	}
    	
    	$price = number_format(round($price,2),2,'.','');//format price
    	
    	if($show_symbol) //add symbol of currency
    	{
    		$price = ( $currency['symbol_location'] =='before' )? ($currency['symbol'].$price) : ($price.$currency['symbol']);
    	}
    	
    	return $price;
    }
    
    /**
     * Return default currency record.
     *
     * @return array
     */
    private function getDefaultCurrency()
    {
    	return $this->db->get_where($this->c_table, array( "default" => 1 ))->row_array();
    }
	
    /**
     * Return currecncy record by currency code.
     *
     * @param char(3) $code
     * @return array
     */
	private function getCurrencyByCode($code)
	{
		return $this->db->get_where($this->c_table, array( "code" => $code ))->row_array();
	}
	
	/**
	 * Return list of enabled currencies.
	 *
	 * @return array
	 */
	private function getEnabledCurrencies()
	{
		return $this->db->get_where($this->c_table, array( "enabled" => 1 ))->result_array();
	}
	
	/**
	 * Return list of enabled currencies' codes.
	 *
	 * @param bool $full
	 * @return array
	 */
	public function getEnabledCurrenciesCodes($full=FALSE)
	{
		$records = $this->getEnabledCurrencies();
		$codes = array();
		foreach ($records as $record)
		{
			$codes[$record['code']] = ($full)?$record:$record['title'];
		}
		
		return $codes;
	}
	
	/**
	 * Return code of current currency.
	 *
	 * @return char(3)
	 */
	public function getCurrentCurrencyCode()
	{
		$code = $this->session->userdata('current_currency_code');//takes currency from session 
    	if(!$code) $code = $this->default_currency['code'];//takes default currency if no in session 
    	
    	return $code;
	}
	
	/**
	 * Check if currency enabled.
	 *
	 * @param char(3) $code
	 * @return bool
	 */
	private function isEnableCurrencyCode($code)
	{
		return in_array($code,array_keys($this->getEnabledCurrenciesCodes()));
	}
	
	/**
	 * Insert or update data. Depends if ID field presents in array.
	 * Override parent method.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function insertOrUpdate($post)
	{
	    if($post['default']) 
	    {
	        $this->db->update($this->c_table, array('default'=>0));
	        $post['enabled'] = 1;
	    }
	    
	    return parent::insertOrUpdate($post);
	}
}