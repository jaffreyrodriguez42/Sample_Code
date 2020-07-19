<?php

//The file "sample_code" is part of my asset management system using Laravel. It shows the flow of how "Deny", "Tag as //returned" and "Approved" buttons work. If non-admin user creates request, the admin user has the option to "Deny" or //"Approve" the request. If the non-admin user's request is "Approved", the system automatically set the status of the //request to "Approved" and automatically look for an asset that is "Available" and with the right asset category. And //lastly, once the asset is returned back, the availabilty of the asset changes to "Available" and can be borrowed again by //other non-admin users.

    // Request Various Status
    //1 = Pending
    //2 = Approved
    //3 = Cancelled
    //4 = Returned
    //5 = Denied
    
    $this->authorize('update', Transaction::class); // checks if user is "Admin", there was Policy created to check if user is "Admin"
    $denied = $request->input('deny'); //get the value of the input element button "Deny"
    $approved = $request->input('approve'); //get the value of the input element button "Approve"
    $returned = $request->input('return'); //get the value of the input element button "Tag as returned"

    if($denied){ //if the "Deny" button is clicked
        if($transaction->status_id != 1){ //if status of the asset is no longer "Pending" due to non-admin user cancelled his request
            //this is what is going to happen if admin tries to deny request but non-admin user already cancelled the request
            return redirect('/transactions'); //go back to transaction page
        }else{ //if status of the request is still "Pending" so it can still be denied by the admin user
            $transaction->status_id = 5; //change the request status to "Denied"
        }        
    }elseif($returned){ //if the "Tag as returned" button is clicked
        $transaction->status_id = 4; //change status of the request to "Returned"
        $transaction->asset->isAvailable = 1; //make particular asset "Available'
        $transaction->asset->save(); //save to database 
    }elseif($approved){ //if the "Approved" button is clicked
        if($transaction->status_id != 1){ //if status of the asset is no longer "Pending" due to non-admin user cancelled his request
            //this is what is going to happen if admin tries to approve request but non admin already cancelled it
            return redirect('/transactions'); //go back to transaction page
        }else{ //if status of the request is still "Pending" so it can still be approved by the admin user         
             $transaction->status_id = 2; //change request status to "Approved"
             $asset = Asset::where('isAvailable', 1)->where('category_id', $transaction->category_id)->get()->first(); //get the particular asset object which is "Available" and with the same "category id" in the transactions table
        }

       if($asset != null){ //if there is "Available" asset or serial number of a particular category
            $transaction->asset_id = $asset->id; //save the asset_id to the transaction table
            $asset->isAvailable = 0; //update the "isAvailble" column of the asset to "Unavailable" or "0"
            $asset->save(); //save asset table  
       }else{ //if no available asset or serial number
            return redirect('/transactions'); // go back to transaction page
       }      
    }else{
        //if no button is clicked 
    }
    $transaction->save(); //save transaction table
    return redirect('/transactions'); //go back to transaction page
}