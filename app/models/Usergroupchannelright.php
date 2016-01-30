<?php
/**
 * Created by PhpStorm.
 * User: fulfilldirect
 * Date: 9/6/2015
 * Time: 7:48 PM
 */


class Usergroupchannelright extends Eloquent{

    /**
     * The database table used by the model.
     *
     * @var string
     */

    // Table Name to be used
    protected $table = 'usergroupchannelrights';


    // Overwriting Default Audits Fields with the Fields in Table
    const CREATED_AT = 'CREATE_TS';
    const UPDATED_AT  = 'MODIFY_TS';

    protected $primaryKey = 'UserGroupChannelRight_Id';


    public function channelright()
    {
        return $this->hasOne('Channelright',"ChannelRight_Id","ChannelRight_Id");
    }




}