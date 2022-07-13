export default class APIService {

  static async callServerByFetchReturnObject(url, options = null) {
    const fetchResponse = await fetch(url, options)
    const response = await fetchResponse.text();
    return JSON.parse(response);
  }


  getJavascriptModel(phpModel, javascriptModel) {

    const getConvertedPhpModel = (phpModel) => {
      let convertedPhpModel = phpModel
      const phpModelPropertyNames = Object.keys(phpModel)

      function getJavascriptPropertyName(phpPropertyName) {



        while ( phpPropertyName.indexOf('_') != -1 ) {
          const index = phpPropertyName.indexOf('_')

          function replaceLowercaseToUppercase(phpPropertyName) {
            return phpPropertyName.replaceAt(index+1, phpPropertyName.substring(index+1, index+2).toUpperCase())
          }

          function removeUnderscore(phpPropertyName) {
            return phpPropertyName.slice(0,index) + phpPropertyName.slice(index + 1)
          }

          phpPropertyName = replaceLowercaseToUppercase(phpPropertyName)
          phpPropertyName = removeUnderscore(phpPropertyName)

        }
        return phpPropertyName
      }


      phpModelPropertyNames.forEach((propertyName) => {
        const javascriptPropertyName = getJavascriptPropertyName(propertyName)
        if (javascriptPropertyName != propertyName)
        {
          phpModel[javascriptPropertyName] = phpModel[propertyName]
          delete phpModel[propertyName]
        }
      })
      convertedPhpModel = phpModel
      return convertedPhpModel
    }

    const convertedPhpModel = getConvertedPhpModel(phpModel)

    for (const [javascriptModelProperty, javascriptModelValue] of Object.entries(javascriptModel)) {
      for (const [convertedPhpModelProperty, convertedPhpModelValue] of Object.entries(convertedPhpModel)) {
        if (javascriptModelProperty === convertedPhpModelProperty)
          javascriptModel[javascriptModelProperty] = convertedPhpModelValue
      }
    }


    return new Promise(function(resolve, reject) {
      resolve(javascriptModel);
    })
  }

}
