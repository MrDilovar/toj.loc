import React from 'react'

const FilterCategory = (props) => {
    let filter = props.filter;
    let defaultOption = filter.values.map(value => (
        <div key={value.id} className="item">
            <label htmlFor={filter.slug + value.id}>
                <span className="text">{value.value}</span>
                <input type="checkbox" id={filter.slug + value.id}
                       onChange={props.checkboxHandler.bind(this, filter.slug, value.id)} />
                <span className="checkmark" />
            </label>
        </div>
    ));

    return (
        <div className="filter-block">
            <div className="filter-title">
                <span>{filter.name}</span>
                <i className="ti-angle-right angle" />
            </div>
            <div className="selectors-block hide-block hide">
                {defaultOption}
            </div>
        </div>
    )
};

export default FilterCategory
