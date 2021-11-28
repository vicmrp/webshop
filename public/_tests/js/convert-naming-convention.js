String.prototype.replaceAt = function(index, replacement) {
  return this.substr(0, index) + replacement + this.substr(index + replacement.length);
}


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

const json = '{"email": "test@steengede.com", "user_credentials_is_valid": "true", "php_session_is_active": "true"}'
const phpModel = JSON.parse(json)

const result = returnConvertedPhpModel(phpModel)
console.log(result);