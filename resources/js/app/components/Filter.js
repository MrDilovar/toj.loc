import React from 'react';
import ReactDOM from 'react-dom';
import FilterPrice from './FilterPrice';
import FilterCategory from "./FilterCategory";

class Filter extends React.Component{

    constructor(props) {
        super(props);

        this.state = {
            products: 0
        }

        this.params = {
            categoryId: this.props.categoryId,
            filters: {},
        }
    }

    componentDidMount() {
        this.getCountProduct();
    }

    getCountProduct() {
        axios.post('/filters/count', this.params)
            .then((response) => {
                this.setState({products: response.data.count})
            })
            .catch(function (error) {
                console.log('Error');
            });
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

    submit () {
        return (
            <div className="filter-block">
                <button className="btn btn-sm btn-primary">Показать {this.state.products} объявления</button>
            </div>
        );
    }

    render() {
        let content = this.props.filterModel.map((filter) => {
            return <FilterCategory key={filter.id} filter={filter} checkboxHandler={this.checkboxHandler.bind(this)} />;
        });

        return (
            <div className="c-filter-widget">
                <FilterPrice priceHandler={this.priceHandler.bind(this)} />
                {content}
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
        defaultOpened = filterPanelLeft.dataset.defaultOpened;

    ReactDOM.render(
        <Filter categoryId={categoryId} filterModel={filterModel} defaultOpened={defaultOpened} />,
        filterPanelLeft
    );
}
