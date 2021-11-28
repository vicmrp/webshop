

export default class Interface {

  async callServerByFetchReturnObject(url, options = null) {
    const fetchResponse = await fetch(url, options)
    const response = await fetchResponse.text();
    return JSON.parse(response);
  }


  callServerByHttpRequestCallback(method, url, body, callback) {
    let xhttp;
    xhttp= new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (typeof callback === "function") {
                callback(this)
            }            
        }
    };
    xhttp.open(method, url, true);
    xhttp.send(body);
  }

  
  getJavascriptModel(phpModel, javascriptModel) {
    // returnModel
    // getModel
    // console.log(javascriptModel);



    // returns array of converted properties
    // return modified object
    // const convertNamingConvention = (phpModel) => {

    //   let _javascriptPropertyNames = []
    //   const _phpPropertyNames = Object.keys(phpModel)

    
    //   function convertPropertyNameConvetionFromPhpToJs(propertyName) {
    //     while ( propertyName.indexOf('_') != -1 ) {
    //       const index = propertyName.indexOf('_')
        
    //       function replaceLowercaseToUppercase(propertyName) {
    //         return propertyName.replaceAt(index+1, propertyName.substring(index+1, index+2).toUpperCase())
    //       }
        
    //       function removeUnderscore(propertyName) {
    //         return propertyName.slice(0,index) + propertyName.slice(index + 1)
    //       }
        
    //       propertyName = replaceLowercaseToUppercase(propertyName)
    //       propertyName = removeUnderscore(propertyName)
        
    //     }
    //     return propertyName
    //   }
    
    //   _phpPropertyNames.forEach((item) => {
    //     _javascriptPropertyNames.push(convertPropertyNameConvetionFromPhpToJs(item))
    //   })
    //   return _javascriptPropertyNames
    // }




    const returnConvertedPhpModel = (phpModel) => {
      const _phpPropertyNames = Object.keys(phpModel)
    
      function convertPropertyNameConvetionFromPhpToJs(propertyName) {
        while ( propertyName.indexOf('_') != -1 ) {
          const index = propertyName.indexOf('_')
        
          function replaceLowercaseToUppercase(propertyName) {
            return propertyName.replaceAt(index+1, propertyName.substring(index+1, index+2).toUpperCase())
          }
        
          function removeUnderscore(propertyName) {
            return propertyName.slice(0,index) + propertyName.slice(index + 1)
          }
        
          propertyName = replaceLowercaseToUppercase(propertyName)
          propertyName = removeUnderscore(propertyName)
        
        }
        return propertyName
      }
    
      _phpPropertyNames.forEach((item) => {
        const javascriptPropertyName = convertPropertyNameConvetionFromPhpToJs(item)    
        if (javascriptPropertyName != item)
        {
          phpModel[javascriptPropertyName] = phpModel[item]
          delete phpModel[item]
        }
      })
      return phpModel
    }


    

    const convertedPhpModel = returnConvertedPhpModel(phpModel)
    // console.log(convertedPhpModel);

    for (const [javascriptModelProperty, javascriptModelValue] of Object.entries(javascriptModel)) {
      // console.log(`property : ${javascriptModelProperty}, value: ${value}`);
      for (const [convertedPhpModelProperty, convertedPhpModelValue] of Object.entries(convertedPhpModel)) {
        
        if (javascriptModelProperty === convertedPhpModelProperty)
          javascriptModel[javascriptModelProperty] = convertedPhpModelValue
      }
    }


    console.log(javascriptModel);

    

    


    

    // let count = 0
    // expectedProperties.forEach(expectedProperty => { 
    //   for (const [property, value] of Object.entries(serverResponse)) {
    //     if (expectedProperty === property)
    //     count++
    //   }
    // });

    // return new Promise((resolve, reject) => {
    //   resolve((count === expectedProperties.length) ? true : false)
    // })
  }

 
}
