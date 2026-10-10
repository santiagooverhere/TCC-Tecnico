String _doisDigitos(int n) => n.toString().padLeft(2, '0');

String formatarDataHora(DateTime data) {
  final d = data.toLocal();
  return '${_doisDigitos(d.day)}/${_doisDigitos(d.month)}/${d.year} às ${_doisDigitos(d.hour)}:${_doisDigitos(d.minute)}';
}

String formatarDataHoraIso(String? iso) {
  if (iso == null) return '';
  final data = DateTime.tryParse(iso);
  if (data == null) return '';
  return formatarDataHora(data);
}
