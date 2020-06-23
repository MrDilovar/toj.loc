import React from 'react';
import ReactDOM from 'react-dom';
import FilterPrice from './FilterPrice';
import FilterCategory from "./FilterCategory";

class Filter extends React.Component{

    constructor(props) {
        super(props);

        this.state = {
            products: 0,
            href: window.location.href
        }

        this.params = {
            categoryId: this.props.categoryId,
            filters: props.openFilters,
        }
    }

    componentDidMount() {
        this.getCountProduct();
    }

    getCountProduct() {
        axios.post('/filters/count', this.mapParamLikeUrl())
            .then((response) => {
                this.setState({products: response.data.count, href: response.data.href});
            })
            .catch(function (error) {
                console.log('Error');
            });
    }

    mapParamLikeUrl() {
        let params = Object.assign({}, this.params);

        for (let [key, value] of Object.entries(params.filters)) {
            params[key] = value.join(';');
        }

        delete params.filters;
        return params;
    }

    setValueParam(param, value) {
        this.params.filters[param].push(value);
        return this;
    }

    hasParam(param) {
        return this.params.filters.hasOwnProperty(param);
    }

    unsetParam(param) {
        delete this.params.filters[param];
        return this;
    }

    createParam(param) {
        this.params.filters[param] = [];
        return this;
    }

    checkboxHandler(filterSlug, valueId) {
        let filter = filterSlug;

        if (this.hasParam(filter)) {
            const index = this.params.filters[filter].indexOf(valueId);

            if  (index > -1) {
                this.params.filters[filter].splice(index, 1);

                if (!this.params.filters[filter].length) this.unsetParam(filter);
            } else this.setValueParam(filter, valueId);
        } else this.createParam(filter).setValueParam(filter, valueId);

        this.getCountProduct();
    }

    priceHandler(param, e) {
        let value = parseInt(e.target.value)

        if (isNaN(value)) {
            delete this.params[param];
        } else {
            this.params[param] = value;
        }

        this.getCountProduct();
    }

    validPrices(openFilters) {
        let openFilterPrice = {};

        ['priceTo', 'priceFrom'].map(function (price) {
            if (openFilters.hasOwnProperty(price)) {
                openFilterPrice[price] = openFilters[price];
                delete openFilters[price];
            }
        });

        return [openFilters, openFilterPrice];
    }

    mapOpenFiltersLikeParam(openFilters) {
        for (let [key, value] of Object.entries(openFilters)) {
            this.params.filters[key] = value.split(';').map( (item) => (parseInt(item)))
                .filter((item) => (!isNaN(item)));
        }
    }

    submit () {
        return (
            <div className="filter-block">
                <a href={this.state.href} className="btn btn-sm btn-primary">Показать {this.state.products} объявления</a>
            </div>
        );
    }

    render() {
        let [openFilters, openFilterPrice] = this.validPrices(this.props.openFilters);
        this.mapOpenFiltersLikeParam(openFilters);

        console.log(openFilterPrice);

        let filterCategory = this.props.filterModel.map((filter) => {
            return <FilterCategory key={filter.id} filter={filter}
                                   openFilters={this.params.filters}
                                   checkboxHandler={this.checkboxHandler.bind(this)} />;
        });

        return (
            <div className="c-filter-widget">
                <FilterPrice openFilterPrice={openFilterPrice} priceHandler={this.priceHandler.bind(this)} />
                {filterCategory}
                {this.submit()}
            </div>
        )
    }
}

export default Filter;

let filterPanelLeft = document.getElementById('filterPanelLeft');

if (filterPanelLeft) {
    let categoryId = filterPanelLeft.dataset.categoryId,
        filterModel = JSON.parse(filterPanelLeft.dataset.filterModel),
        openFilters = JSON.parse(filterPanelLeft.dataset.openFilters);

    ReactDOM.render(
        <Filter categoryId={categoryId} filterModel={filterModel} openFilters={openFilters} />,
        filterPanelLeft
    );
}
