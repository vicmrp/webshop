#!bin/bash

# /mnt/byg-cserver1.win.dtu.dk-BYG-vicre-linux-0-0-home4_Users4_vicre_P_www/tspa.byg.dtu.dk/scripts/dev/bash/root
# bash Test-ADAuthentication.sh --Username 'Administrator' --Identity 'Passw0rd' --GroupMember 'Administrators' # >> True
# bash Test-ADAuthentication.sh --Username 'Administrator' --Identity 'Passw0rd' --GroupMember '\$null' # >> True

# bash Test-ADAuthentication.sh --Username 'bob' --Identity 'Passw0rd' --GroupMember 'DnsAdmins' # >> True
# bash Test-ADAuthentication.sh --Username 'bob' --Identity 'Passw0rd' --GroupMember 'Administrators' # >> False

# Indhenter navngivne parametere
while [ $# -gt 0 ]; do

    if [[ $1 == *"--"* ]]; 
    then
        param="${1/--/}"
        declare $param="$2"
        # echo $1 $2 // Optional to see the parameter:value result
    fi
    shift # Gør så at $2 bliver til $1
done

result=$( bash -c ' \
    ssh byg-vicre-linux@tspa-windows.byg.dtu.dk " \
        cd tspa_windows;                                                        \
        .\Test-ADAuthentication.ps1                                             \
        -Username '$Username'                                                   \
        -Identity '$Identity'                                                   \
        -GroupMember '$GroupMember'                                             \
    " 2> /dev/null');

printf "$result"
