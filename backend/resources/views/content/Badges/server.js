export default class {
    url = "";
    actualPage = 1;
    maxDataPerPage = 100;
    axios = null;
    method = 'post';
    on = {}
    global_search_query = "";
    global_search_columns = [];
    filter_columns = {};

    constructor(axios, method = 'post') {
        this.axios = axios
        this.method = method

    }

    // permet de recuperer l'url actuel
    getUrl() {
        return this.url
    }

    // permet de mettre a jour l'url
    setUrl(newUrl) {
        this.url = newUrl
    }

    // permet de recuperer l'actualPage actuel
    getActualPage() {
        return this.actualPage
    }

    // permet de mettre a jour l'actualPage
    setActualPage(actualPage) {
        this.actualPage = actualPage
    }

    // permet de recuperer l'maxDataPerPage actuel
    getMaxDataPerPage() {
        return this.maxDataPerPage
    }

    // permet de mettre a jour l'maxDataPerPage
    setMaxDataPerPage(maxDataPerPage) {
        this.maxDataPerPage = maxDataPerPage
    }

    // permet de recuperer le global_search_query
    getGlobalSearchQuery() {
        return this.global_search_query
    }

    // permet de mettre a jour le global_search_query
    setGlobalSearchQuery(global_search_query) {
        this.global_search_query = global_search_query
    }

    // permet de recuperer le global_search_columns
    getGlobalSearchColumns() {
        return this.global_search_columns
    }

    // permet de mettre a jour le global_search_columns
    setGlobalSearchColumns(global_search_columns) {
        this.global_search_columns = global_search_columns
    }

    // permet de reajouter des evenements
    addOn(name, callback) {
        let allCallback = [];
        if (Object.keys(this.on).includes(name)) {
            allCallback = this.on[name]

        }
        allCallback.push(callback)
        this.on[name] = allCallback
    }

    globalSearch(query, columns, load = true) {
        this.setGlobalSearchQuery(query)
        this.setGlobalSearchColumns(columns)
        if (load) {
            this.load(1)
        }

    }

    addColumnSearch(query, column, type = 'set') {
        console.log('filter_columns')

        this.filter_columns[column] = {query: query, type: type}
        console.log('filter_columns', this.filter_columns)

    }

    load(page = -1) {
        if (page == -1) {
            page = 1
        }

        this.setActualPage(page)
        this._load();
    }

    _getParams() {
        return {
            "startRow": this._getStartRow(),
            "endRow": this._getEndRow(),
            "rowGroupCols": [],
            "valueCols": [],
            "pivotCols": [],
            "pivotMode": false,
            "groupKeys": [],
            "filterModel": {},
            "sortModel": [],
            "__filter__": {},
            "__extras__": this._getExtrasData()
        };
    }

    _getFilterModel() {
        let params = {}

        Object.keys(this.filter_columns).forEach(data => {
            let donnee = this.filter_columns[data]
            if (donnee.query !== '') {
                // params[]
            }
        })
        return params

    }

    _getExtrasData() {
        let params = {baseFilter: {}}
        console.log('_getExtrasData=>this.filter_columns', this.filter_columns)
        Object.keys(this.filter_columns).forEach(data => {
            let donnee = this.filter_columns[data]
            params['baseFilter'][data] = {values: donnee.query, filterType: 'set'}

        })
        // if (this.filterKey !== "" && this.filterValue !== "") {
        //     params['baseFilter'][this.filterKey] = {values: [this.filterValue], filterType: 'set'}
        // }
        let globalColumns = this.getGlobalSearchColumns();
        let globalQuery = this.getGlobalSearchQuery();
        if (
            Array.isArray(globalColumns) &&
            globalColumns.length > 0 &&
            globalQuery !== ""
        ) {
            params['filterFields'] = globalColumns;
            params['globalSearch'] = globalQuery;
        }
        console.log('voila les paramettres ==>', params, globalColumns, globalQuery)
        return params

    }

    _getStartRow() {
        let alpha = 0;
        try {
            alpha = this.actualPage - 1
        } catch (e) {
        }
        if (alpha < 0) {
            alpha = 0
        }
        return this.maxDataPerPage * alpha

    }

    _getEndRow() {
        let alpha = this.actualPage;
        return this.maxDataPerPage * alpha

    }

    _load() {

        let params = this._getParams();
        if (this.method == 'post') {
            this.axios.post(this.url, params).then(response => {
                this.isLoading = false
                let allEvent = [];
                if (Object.keys(this.on).includes('dataLoadSuccess') && Array.isArray(this.on.dataLoadSuccess)) {
                    allEvent = this.on.dataLoadSuccess
                }
                allEvent.forEach(callBack => {
                    callBack(this, response.data)
                })
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
            })
        } else {
            this.axios.post(this.url, params).then(response => {
                this.isLoading = false
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
            })
        }


    }

    refresh() {

        this.load(this.actualPage)


    }
}
