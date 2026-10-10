import 'package:flutter/material.dart';
import '../utils/formatadores.dart';

class SeletorDataHora extends StatelessWidget {
  final DateTime valor;
  final ValueChanged<DateTime> onChanged;

  const SeletorDataHora({super.key, required this.valor, required this.onChanged});

  Future<void> _escolher(BuildContext context) async {
    final agora = DateTime.now();

    final data = await showDatePicker(
      context: context,
      initialDate: valor.isAfter(agora) ? agora : valor,
      firstDate: DateTime(2020),
      lastDate: agora,
    );
    if (data == null || !context.mounted) return;

    final hora = await showTimePicker(
      context: context,
      initialTime: TimeOfDay.fromDateTime(valor),
    );
    if (hora == null) return;

    var novo = DateTime(data.year, data.month, data.day, hora.hour, hora.minute);
    if (novo.isAfter(agora)) novo = agora;
    onChanged(novo);
  }

  @override
  Widget build(BuildContext context) {
    return InkWell(
      borderRadius: BorderRadius.circular(12),
      onTap: () => _escolher(context),
      child: InputDecorator(
        decoration: const InputDecoration(
          labelText: 'Data e hora em que foi encontrado',
          prefixIcon: Icon(Icons.event),
        ),
        child: Text(
          formatarDataHora(valor),
          style: const TextStyle(color: Colors.white),
        ),
      ),
    );
  }
}
