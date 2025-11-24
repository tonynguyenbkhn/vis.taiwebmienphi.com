<?php
/*
Since 12.9
When initiate this class must pass the following params:
$arr = [
          'lid'             => 0,// membership id, int
          'recaptcha_value' => '',// recaptcha value, string
];
*/
namespace Indeed\Ihc\Payments;

class ValidateRecaptchaStripe
{
    /**
     * @var array
     */
    private $input          = [];

    /**
     * @param array
     * @return none
     */
    public function __construct( $input=[] )
    {
        $this->input = $input;
    }

    /**
     * @param none
     * @return bool
     */
    public function canDoCheck()
    {
        global $current_user;
        $uid = isset( $current_user->ID ) ? $current_user->ID : 0;
        if ( !empty( $uid ) ){
            // user its registered so we do not need another check
            return false;
        }

        if ( !isset( $this->input['lid'] ) ){
            // no input membership id
            return false;
        }

        // form has recaptcha ?
        if ( !iumpRegisterFieldAvailableForMembership( 'recaptcha', $this->input['lid'] ) ){
            return false;
        }

        // its properly set ?
        if ( !$this->isProperlySet() ){
            return false;
        }

        return true;
    }

    /**
     * @param none
     * @return int
     */
    public function check()
    {
        $validateForm = new \Indeed\Ihc\ValidateForm();
        $response = $validateForm->checkRecaptcha( ['g-recaptcha-response' => $this->input['recaptcha_value'] ]  );
        if ( !isset( $response['status'] ) || empty( $response['status'] ) ){
            return false;
        }
        return (bool)$response['status'];
    }

    /**
     * @param none
     * @return bool
     */
    public function isProperlySet()
    {
        $type = get_option( 'ihc_recaptcha_version' );
        $secret = get_option('ihc_recaptcha_private_v3');
        if ( $type === false || $type !== 'v3' || $secret === false || $secret === null || $secret === '' ){
            // recaptcha its not set so we cannot do the check
            return false;
        }
        return true;
    }
}
