import 'package:url_launcher/url_launcher.dart';

Future<bool> abrirEmailContato({
  required String email,
  required String assunto,
  required String mensagem,
}) async {
  final mailto = Uri.parse(
    'mailto:$email?subject=${Uri.encodeComponent(assunto)}&body=${Uri.encodeComponent(mensagem)}',
  );

  try {
    if (await launchUrl(mailto, mode: LaunchMode.externalApplication)) return true;
  } catch (_) {}

  final gmail = Uri.https('mail.google.com', '/mail/', {
    'view': 'cm',
    'fs': '1',
    'to': email,
    'su': assunto,
    'body': mensagem,
    'tf': 'cm',
  });

  try {
    return await launchUrl(gmail, mode: LaunchMode.externalApplication);
  } catch (_) {
    return false;
  }
}
