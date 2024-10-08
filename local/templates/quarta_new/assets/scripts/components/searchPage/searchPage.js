class SearchPage {

    constructor(params) {

        const templateFolder = params?.templateFolder
        const paramsCatalog = params?.paramsCatalog
        const searchCount = params?.countSearch
        const pageSize = params?.pageSize
        const countProduct = params?.countProduct

        if (countProduct == 0) return
        if (searchCount == 0) return

        new SearchPageSort({
            templateFolder: templateFolder,
            paramsCatalog: paramsCatalog,
            pageSize: pageSize
        })
    }

}