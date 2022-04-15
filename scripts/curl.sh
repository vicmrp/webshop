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

curl -v -su ":$Apikey" -H 'Accept-Version: v10' https://api.quickpay.net/account
