import React from 'react'

const FilterCategory = (props) => {
    let selectorsBlock;
    let filter = props.filter;

    if (props.openFilters.hasOwnProperty(filter.slug)) {
        let checkedOption = filter.values.map(value => (
            <div key={value.id} className="item">
                <label htmlFor={filter.slug + value.id}>
                    <span className="text">{value.value}</span>
                    <input type="checkbox" id={filter.slug + value.id}
                           onChange={props.checkboxHandler.bind(this, filter.slug, value.id)}
                           defaultChecked={props.openFilters[filter.slug].indexOf(value.id) >= 0} />
                    <span className="checkmark" />
                </label>
            </div>
        ));
        selectorsBlock = <div className="selectors-block hide-block show" style={{display: 'block'}}>{checkedOption}</div>;
    } else {
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
        selectorsBlock = <div className="selectors-block hide-block hide">{defaultOption}</div>;
    }

    return (
        <div className="filter-block">
            <div className="filter-title">
                <span>{filter.name}</span>
                <i className="ti-angle-right angle" />
            </div>
            {selectorsBlock}
        </div>
    )
}

export default FilterCategory
