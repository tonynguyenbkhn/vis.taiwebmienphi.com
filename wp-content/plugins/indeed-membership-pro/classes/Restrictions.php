<?php
namespace Indeed\Ihc;

class Restrictions
{
    /**
     * @var int
     */
    private static $currentPost             = null;
    /**
     * @var int
     */
    private static $userId                  = null;
    /**
     * @var string
     */
    private static $userType                = 'unreg';
    /**
     * @var array
     */
    private static $userMemberships         = [];
    /**
     * @var array
     */
    private static $posts                   = [];

    /**
     * @param none
     * @return none
     */
    public function __construct(){}

    /**
     * @param int
     * @return none
     */
    public static function setPostId( $input=0 )
    {
        if ( $input === 0 ){
            return;
        }
        self::$currentPost = $input;
    }

    /**
     * @param int
     * @return none
     */
    public static function setUser( $input=0 )
    {
        // set user id

    }

    public static function getResult()
    {
        return self::$userMemberships;
    }

}
