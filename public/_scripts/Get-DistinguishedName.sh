#!bin/bash

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
        .\Get-DistinguishedName.ps1                                             \
        -Computername '$Computername'                                           \
    " 2> /dev/null');

printf "$result"
