// let property = 'user_credentials_is_valid'


// console.log(property.indexOf('_')) // forventer 4
String.prototype.replaceAt = function(index, replacement) {
  return this.substr(0, index) + replacement + this.substr(index + replacement.length);
}

// const index = property.indexOf('_') // forventer 4

// property = property.slice(0,index) + property.slice(5)

// console.log('_credentials_is_valid'.length)





// slet underscore og første bugstav til højre

// slet underscore og noter første bugstav til højre for og herefter erstart med stort

// while ( property.indexOf('_') != -1 ) {
//   const index = property.indexOf('_')

//   function replaceLowercaseToUppercase(property) {
//     return property.replaceAt(index+1, property.substring(index+1, index+2).toUpperCase())
//   }

//   function removeUnderscore(property) {
//     return property.slice(0,index) + property.slice(index + 1)
//   }

//   property = replaceLowercaseToUppercase(property)
//   property = removeUnderscore(property)

// }


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


// function returnResult(property) {
  
//   console.log(property)

//   property = property.slice(0,index) + property.slice(property.length-index)

//   if 
// }
let property = 'user_credentials_is_valid'
const result = convertPropertyNameConvetionFromPhpToJs(property)
console.log(result);
