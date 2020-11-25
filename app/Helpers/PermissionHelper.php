<?php

    function access_information(){
        
    }
    function checkRole_Permission($role,$permission,$role_permission)
    {
        if(!empty($role_permission))
        {
            foreach($role_permission AS $k => $d)
            {
                if($permission==$d->permission_id&&$role==$d->role_id)
                {
                    return true;
                }
            }
        }
        else
        {
            return false;
        }
    }
 
