import React, { Component } from 'react'
import { Form, Button, Row, Col, Card, Modal, Table } from 'react-bootstrap';
import axios from 'axios'
import Select from 'react-select'

export default class MSelectProvinsi extends Component {
  static defaultProps = {
    disabled: false
  }

  constructor(props){
    super(props)

    this.state = {
      data: []
    }
  }

  componentDidMount(){
    axios.get(`/api/provinsi`).then(response => {
      let data = []

      response.data.map((d) => {
        data.push({
          value: d.id_provinsi,
          label: d.nama
        })
      })

      this.setState({
        data: data,
        loading: false
      })
    }).catch(err => {
      console.log(err.response)

      this.setState({
        loading: false,
      })
    })
  }

  render() {
    return (
      <Form.Group style={{...this.props.style}} className={this.props.className}>
        <Form.Label>Provinsi</Form.Label>
        <Select isDisabled={this.props.disabled} placeholder="-- pilih provinsi --" value={this.props.value != "" ? this.state.data.filter(obj => {return obj.value == this.props.value})[0] : ""} options={this.state.data} onChange={(val) => this.props.onChange(val)}/>
      </Form.Group>
    )
  }
}
