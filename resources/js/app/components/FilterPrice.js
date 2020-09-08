import React from 'react';

const FilterPrice = (props) => {
    return(
        <div className="filter-block">
            <div className="filter-title">
                <span>Цена</span>
                <i className="ti-angle-down angle" />
            </div>
            <div className="price-block hide-block">
                <div className="row">
                    <div className="col">
                        <label aria-label="Цена от" htmlFor="priceFrom">от</label>
                        <input onChange={props.priceHandler.bind(this, 'priceFrom')}
                               className="form-control form-control-sm"
                               defaultValue={0}
                               id="priceFrom" type="text" />
                    </div>
                    <div className="col">
                        <label aria-label="Цена до" htmlFor="priceTo">до</label>
                        <input onChange={props.priceHandler.bind(this, 'priceTo')}
                               className="form-control form-control-sm"
                               id="priceTo" type="text" />
                    </div>
                </div>
            </div>
        </div>
    );
};

export default FilterPrice;
