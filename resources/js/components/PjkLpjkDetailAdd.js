import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Tabs, Tab, Form, Spinner, Col, Row, Modal} from 'react-bootstrap';
import axios from 'axios'
// import moment from 'moment'
// import SweetAlert from 'react-bootstrap-sweetalert';
// import Alert from 'react-s-alert';

import MSelectProvinsi from './MSelectProvinsi'

export default class Main extends Component {
  constructor(props){
    super(props);

    this.state = {
      idx: 0,
      row: [0],
      provinsi: [],
      bidang: [],
      sub_bidang: [[]],
      jenis_usaha: []
    }
  }

  componentDidMount() {

    this.getProvinsi();
    this.getBidang();
    this.getJenisUsaha();
  }

  getProvinsi() {
    axios.get(`/api/v1/provinsi`).then(response => {
      this.setState({
        provinsi: response.data,
        loading: false
      })
    });
  }

  getJenisUsaha() {
    axios.get(`/api/v1/jenis_usaha`).then(response => {
      this.setState({
        jenis_usaha: response.data,
        loading: false
      })
    });
  }

  getBidang() {
    axios.get(`/api/v1/bidang`).then(response => {
      this.setState({
        bidang: response.data,
        loading: false
      })
    });
  }

  getSubBidang(subbidang, i) {
    axios.get(`/api/v1/sub_bidang?bidang=` + subbidang).then(response => {
      let sb = this.state.sub_bidang;
      console.log(i)
      sb[i] = response.data;
      this.setState({
        sub_bidang: sb,
        loading: false
      }, () => {
          console.log(this.state.sub_bidang)
      })
    });
  }

  onKlasifikasiChange(e) {
    this.getSubBidang(e.target.value, e.target.dataset.key);
  }

  tambahRow(e) {
    e.preventDefault();
    let row = this.state.row;
    let sb = this.state.sub_bidang;
    row.push(this.state.idx + 1);
    sb.push([]);
    this.setState({row: row, sub_bidang: sb, idx: this.state.idx + 1})
  }

  deleteRow(e) {
    e.preventDefault();
    let row = this.state.row;
    let idx = row.indexOf(parseInt(e.target.dataset.key, 10));
    console.log(row);
    console.log(e.target.dataset.key);
    console.log(idx);
    row.splice(idx, 1)
    this.setState({ row: row });
  }

  handleChange(event){
    this.setState({
      id_personal: event.target.value
    })
  }

  rowDetail(d, i) {
    return (
      <tr key={d} id="detail">
        <td>
          <select className="form-control" name={"jenis_usaha[" + d + "]"} required>
            <option value="">-- jenis usaha --</option>
            {this.state.jenis_usaha.map((p) => (
              <option value={p.id}>{p.nama}</option>
            ))}
          </select>
        </td>
        <td>
          <select className="form-control" name={"provinsi[" + d + "]"} required>
            <option value="">-- pilih provinsi --</option>
            {this.state.provinsi.map((p) => (
              <option value={p.id_provinsi}>{p.nama}</option>
            ))}
          </select>
        </td>
        <td>
          <select className="form-control bidang" name={"klasifikasi[" + d + "]"} data-key={d} onChange={(e) => this.onKlasifikasiChange(e)} required>
            <option value="0">Semua klasifikasi</option>
            {this.state.bidang.map((p) => (
              <option value={p.id_bidang}>{p.id_bidang} - {p.deskripsi}</option>
            ))}
          </select>
        </td>
        <td>
          <select className="form-control subbidang" name={"sub_klasifikasi[" + d + "]"} required>
            <option value="0">Semua Sub klasifikasi</option>
            {this.state.sub_bidang[d].map((p) => (
              <option value={p.id_sub_bidang}>{p.id_sub_bidang} - {p.deskripsi}</option>
            ))}
          </select>
        </td>
        <td>
          <select className="form-control" name={"kualifikasi[" + d + "]"} required>
            <option value="">-- pilih kualifikasi --</option>
            <option value="SKA">SKA</option>
            <option value="SKT">SKT</option>
          </select>
        </td>
        <td>
          <select className="form-control" name={"sub_kualifikasi[" + d + "]"} required>
            <option value="">-- pilih sub kualifikasi --</option>
            <option value="1">Utama / Kelas 1</option>
            <option value="2">Madya / Kelas 2</option>
            <option value="3">Muda / Kelas 3</option>
          </select>
        </td>
        <td><input type="text" className="form-control" name={"no_sk[" + d + "]"} /></td>
        <td><input type="text" className="form-control" name={"tgl_sk[" + d + "]"} /></td>
        <td><input type="text" className="form-control" name={"tgl_sk_akhir[" + d + "]"} /></td>
        {/* <td><textarea name={"keterangan_detail[" + d + "]"} rows="1" className="form-control"></textarea></td> */}
        <td><input type="file" className="form-control" name={"file_sk[" + d + "]"} /></td>
        <td>
          <label>
            <input type="checkbox" name={"is_active_detail[" + d + "]"} checked="checked" /> Active
          </label>
        </td>
        <td>
          {i != 0 && (
            <button className="btn btn-danger btn-xs" data-key={d} onClick={(e) => this.deleteRow(e)}>delete</button>
          )}
        </td>
      </tr>
    );
  }

  render() {
    return (
      <>
        <button className="btn btn-success btn-xs pull-right" onClick={(e) => this.tambahRow(e)}>Tambah Row</button>
        <table className="table table-bordered">
          <thead>
            <tr>
              <th>Jenis Usaha</th>
              <th>Provinsi</th>
              <th>Klasifikasi</th>
              <th>Sub Klasifikasi</th>
              <th>Kualifikasi</th>
              <th>Sub Kualifikasi</th>
              <th>No SK</th>
              <th>Tgl Terbit SK</th>
              <th>Tgl Akhir SK</th>
              <th>Pdf SK</th>
              <th>Active</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            {this.state.row.map((d, i) => this.rowDetail(d, i))}
          </tbody>
        </table>
      </>
    );
  }
}

if (document.getElementById('add-pjs-detail')) {
    ReactDOM.render(<Main />, document.getElementById('add-pjs-detail'));
}
