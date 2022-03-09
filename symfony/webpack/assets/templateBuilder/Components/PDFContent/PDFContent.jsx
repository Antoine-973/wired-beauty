import GraphItem from "../GraphItem/GraphItem"

export default function PDFContent({data, productsList}){
  return(
    <div style={{position: 'relative'}}>
      <h1 style={{ textAlign: 'center', marginTop: '10px' }}>Study title</h1>
      <p className="page-break">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam exercitationem esse tempora vero nulla veniam aspernatur aut aliquam. Cum non quis culpa odit voluptatum vero, nemo incidunt ratione quos sunt.</p>
      <div className="page-break">
        {Object.keys(data).length >0 && 
            <GraphItem
              productsList={productsList}
              data={data} />}
      </div>
    </div>
  )
};