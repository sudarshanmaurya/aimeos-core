<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2013
 * @license LGPLv3, http://www.arcavias.com/en/license
 * @package Client
 * @subpackage Html
 */


// Strings for translation
sprintf('address');


/**
 * Default implementation of checkout address HTML client.
 *
 * @package Client
 * @subpackage Html
 */
class Client_Html_Checkout_Standard_Address_Default
	extends Client_Html_Abstract
{
	/** client/html/checkout/standard/address/default/subparts
	 * List of HTML sub-clients rendered within the checkout standard address section
	 *
	 * The output of the frontend is composed of the code generated by the HTML
	 * clients. Each HTML client can consist of serveral (or none) sub-clients
	 * that are responsible for rendering certain sub-parts of the output. The
	 * sub-clients can contain HTML clients themselves and therefore a
	 * hierarchical tree of HTML clients is composed. Each HTML client creates
	 * the output that is placed inside the container of its parent.
	 *
	 * At first, always the HTML code generated by the parent is printed, then
	 * the HTML code of its sub-clients. The order of the HTML sub-clients
	 * determines the order of the output of these sub-clients inside the parent
	 * container. If the configured list of clients is
	 *
	 *  array( "subclient1", "subclient2" )
	 *
	 * you can easily change the order of the output by reordering the subparts:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1", "subclient2" )
	 *
	 * You can also remove one or more parts if they shouldn't be rendered:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1" )
	 *
	 * As the clients only generates structural HTML, the layout defined via CSS
	 * should support adding, removing or reordering content by a fluid like
	 * design.
	 *
	 * @param array List of sub-client names
	 * @since 2014.03
	 * @category Developer
	 */
	private $_subPartPath = 'client/html/checkout/standard/address/default/subparts';

	/** client/html/checkout/standard/address/billing/name
	 * Name of the billing part used by the checkout standard address client implementation
	 *
	 * Use "Myname" if your class is named "Client_Checkout_Standard_Address_Billing_Myname".
	 * The name is case-sensitive and you should avoid camel case names like "MyName".
	 *
	 * @param string Last part of the client class name
	 * @since 2014.03
	 * @category Developer
	 */

	/** client/html/checkout/standard/address/delivery/name
	 * Name of the delivery part used by the checkout standard address client implementation
	 *
	 * Use "Myname" if your class is named "Client_Checkout_Standard_Address_Delivery_Myname".
	 * The name is case-sensitive and you should avoid camel case names like "MyName".
	 *
	 * @param string Last part of the client class name
	 * @since 2014.03
	 * @category Developer
	 */
	private $_subPartNames = array( 'billing', 'delivery' );

	private $_cache;


	/**
	 * Returns the HTML code for insertion into the body.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return string HTML code
	 */
	public function getBody( $uid = '', array &$tags = array(), &$expire = null )
	{
		$view = $this->getView();

		if( $view->get( 'standardStepActive', 'address' ) != 'address' ) {
			return '';
		}

		$view = $this->_setViewParams( $view, $tags, $expire );

		$html = '';
		foreach( $this->_getSubClients() as $subclient ) {
			$html .= $subclient->setView( $view )->getBody( $uid, $tags, $expire );
		}
		$view->addressBody = $html;

		/** client/html/checkout/standard/address/default/template-body
		 * Relative path to the HTML body template of the checkout standard address client.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the layouts directory (usually in client/html/layouts).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating code for the HTML page body
		 * @since 2014.03
		 * @category Developer
		 * @see client/html/checkout/standard/address/default/template-header
		 */
		$tplconf = 'client/html/checkout/standard/address/default/template-body';
		$default = 'checkout/standard/address-body-default.html';

		return $view->render( $this->_getTemplate( $tplconf, $default ) );
	}


	/**
	 * Returns the HTML string for insertion into the header.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return string String including HTML tags for the header
	 */
	public function getHeader( $uid = '', array &$tags = array(), &$expire = null )
	{
		$view = $this->getView();

		if( $view->get( 'standardStepActive', 'address' ) != 'address' ) {
			return '';
		}

		$view = $this->_setViewParams( $view, $tags, $expire );

		$html = '';
		foreach( $this->_getSubClients() as $subclient ) {
			$html .= $subclient->setView( $view )->getHeader( $uid, $tags, $expire );
		}
		$view->addressHeader = $html;

		/** client/html/checkout/standard/address/default/template-header
		 * Relative path to the HTML header template of the checkout standard address client.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the HTML code that is inserted into the HTML page header
		 * of the rendered page in the frontend. The configuration string is the
		 * path to the template file relative to the layouts directory (usually
		 * in client/html/layouts).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating code for the HTML page head
		 * @since 2014.03
		 * @category Developer
		 * @see client/html/checkout/standard/address/default/template-body
		 */
		$tplconf = 'client/html/checkout/standard/address/default/template-header';
		$default = 'checkout/standard/address-header-default.html';

		return $view->render( $this->_getTemplate( $tplconf, $default ) );
	}


	/**
	 * Returns the sub-client given by its name.
	 *
	 * @param string $type Name of the client type
	 * @param string|null $name Name of the sub-client (Default if null)
	 * @return Client_Html_Interface Sub-client object
	 */
	public function getSubClient( $type, $name = null )
	{
		return $this->_createSubClient( 'checkout/standard/address/' . $type, $name );
	}


	/**
	 * Processes the input, e.g. store given values.
	 * A view must be available and this method doesn't generate any output
	 * besides setting view variables.
	 */
	public function process()
	{
		$view = $this->getView();

		try
		{
			parent::process();

			$basketCntl = Controller_Frontend_Factory::createController( $this->_getContext(), 'basket' );

			// Test if addresses are available
			$addresses = $basketCntl->get()->getAddresses();
			if( !isset( $view->standardStepActive ) && count( $addresses ) === 0 )
			{
				$view->standardStepActive = 'address';
				return false;
			}
		}
		catch( Exception $e )
		{
			$this->getView()->standardStepActive = 'address';
			throw $e;
		}

	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of HTML client names
	 */
	protected function _getSubClientNames()
	{
		return $this->_getContext()->getConfig()->get( $this->_subPartPath, $this->_subPartNames );
	}


	/**
	 * Sets the necessary parameter values in the view.
	 *
	 * @param MW_View_Interface $view The view object which generates the HTML output
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return MW_View_Interface Modified view object
	 */
	protected function _setViewParams( MW_View_Interface $view, array &$tags = array(), &$expire = null )
	{
		if( !isset( $this->_cache ) )
		{
			$context = $this->_getContext();


			$customerManager = MShop_Factory::createManager( $context, 'customer' );

			$search = $customerManager->createSearch( true );
			$expr = array(
				$search->compare( '==', 'customer.id', $context->getUserId() ),
				$search->getConditions(),
			);
			$search->setConditions( $search->combine( '&&', $expr ) );

			$items = $customerManager->searchItems( $search );

			if( ( $item = reset( $items ) ) !== false )
			{
				$view->addressCustomerItem = $item;

				$customerAddressManager = MShop_Factory::createManager( $context, 'customer/address' );

				$search = $customerAddressManager->createSearch();
				$search->setConditions( $search->compare( '==', 'customer.address.refid', $item->getId() ) );

				$view->addressCustomerAddressItems = $customerAddressManager->searchItems( $search );
			}


			$localeManager = MShop_Factory::createManager( $context, 'locale' );
			$locales = $localeManager->searchItems( $localeManager->createSearch( true ) );

			$languages = array();
			foreach( $locales as $locale ) {
				$languages[ $locale->getLanguageId() ] = $locale->getLanguageId();
			}

			$view->addressLanguages = $languages;

			/** client/html/checkout/standard/address/countries
			 * List of available countries that that users can select from in the front-end
			 *
			 * This configration option is used whenever a list of countries is
			 * shown in the front-end users can select from. It's used e.g.
			 * if the customer should select the country he is living in the
			 * checkout process. In case that the list is empty, no country
			 * selection is shown.
			 *
			 * Each list entry must be a two letter ISO country code that is then
			 * translated into its name. The codes have to be upper case
			 * characters like "DE" for Germany or "GB" for Great Britain, e.g.
			 *
			 *  array( 'DE', 'GB', ... )
			 *
			 * To display the country selection, you have to add the key for the
			 * country ID (order.base.address.languageid) to the "mandatory" or
			 * "optional" configuration option for billing and delivery addresses.
			 *
			 * Until 2015-02, the configuration option was available as
			 * "client/html/common/address/countries" starting from 2014-03.
			 *
			 * @param array List of two letter ISO country codes
			 * @since 2015.02
			 * @category User
			 * @category Developer
			 * @see client/html/checkout/standard/address/billing/mandatory
			 * @see client/html/checkout/standard/address/billing/optional
			 * @see client/html/checkout/standard/address/delivery/mandatory
			 * @see client/html/checkout/standard/address/delivery/optional
			 */
			$view->addressCountries = $view->config( 'client/html/checkout/standard/address/countries', array() );

			/** client/html/checkout/standard/address/states
			 * List of available states that that users can select from in the front-end
			 *
			 * This configration option is used whenever a list of states is
			 * shown in the front-end users can select from. It's used e.g.
			 * if the customer should select the state he is living in the
			 * checkout process. In case that the list is empty, no state
			 * selection is shown.
			 *
			 * A two letter ISO country code must be the key for the list of
			 * states that belong to this country. The list of states must then
			 * contain the state code as key and its name as values, e.g.
			 *
			 *  array(
			 *      'US' => array(
			 *          'CA' => 'California',
			 *          'NY' => 'New York',
			 *          ...
			 *      ),
			 *      ...
			 *  );
			 *
			 * The codes have to be upper case characters like "US" for the
			 * United States or "DE" for Germany. The order of the country and
			 * state codes determine the order of the states in the frontend and
			 * the state codes are later used for per state tax calculation.
			 *
			 * To display the country selection, you have to add the key for the
			 * state (order.base.address.state) to the "mandatory" or
			 * "optional" configuration option for billing and delivery addresses.
			 * You also need to add order.base.address.countryid as well because
			 * it is required to display the states that belong to this country.
			 *
			 * Until 2015-02, the configuration option was available as
			 * "client/html/common/address/states" starting from 2014-09.
			 *
			 * @param array Multi-dimensional list ISO country codes and state codes/names
			 * @since 2015.02
			 * @category User
			 * @category Developer
			 * @see client/html/checkout/standard/address/billing/mandatory
			 * @see client/html/checkout/standard/address/billing/optional
			 * @see client/html/checkout/standard/address/delivery/mandatory
			 * @see client/html/checkout/standard/address/delivery/optional
			 */
			$view->addressStates = $view->config( 'client/html/checkout/standard/address/states', array() );


			$this->_cache = $view;
		}

		return $this->_cache;
	}
}